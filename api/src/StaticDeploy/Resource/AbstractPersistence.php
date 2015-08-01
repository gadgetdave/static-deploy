<?php
namespace StaticDeploy\Resource;

use PhlyRestfully\Exception\CreationException;
use PhlyRestfully\Exception\DomainException;
use PhlyRestfully\ResourceEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use PhlyRestfully\Resource;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use StaticDeploy\Paginator\Adapter\Doctrine as DoctrinePaginatorAdapter;
use Doctrine\ORM\AbstractQuery;
use StaticDeploy\Entity\Base;
use OAuth2\Server;
use ZF\OAuth2\Factory\OAuth2ServerFactory;
use OAuth2\Request;
use ZF\OAuth2\Factory\OAuth2ServerInstanceFactory;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractPersistence implements PersistenceInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var \stdClass
     */
    protected $entity;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $identifierName = 'id';

    /**
     * @var OAuth2ServerFactory
     */
    protected $serverFactory;

    /**
     * @var unknown
     */
    protected $server;

    public function __construct(EntityManager $em, OAuth2ServerInstanceFactory $serverFactory)
    {
        $this->serverFactory = $serverFactory;
        $this->entityManager = $em;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function preCreate(Base $entity)
    {
        // lets update the timestamps if possible
        //
        // *** careful we are assuming standard nameing conventions
        // *** assumption is the mother of all f*** ups
        if (method_exists($entity, 'setCreatedDate')) {
            $entity->setCreatedDate(new \DateTime());
        }

        if (method_exists($entity, 'setUpdatedDate')) {
            $entity->setUpdatedDate(new \DateTime());
        }

        if (method_exists($entity, 'setCreatedByUserId')) {
            $entity->setCreatedByUserId($this->getOAuth2Identity()['user_id']);
        }

        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function postCreate(Base $entity)
    {
        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function preUpdate(Base $entity)
    {
        // lets update the timestamps if possible
        //
        // *** careful we are assuming standard nameing conventions
        // *** assumption is the mother of all f*** ups
        if (method_exists($entity, 'setUpdatedDate')) {
            $entity->setUpdatedDate(new \DateTime());
        }

        if (method_exists($entity, 'setUpdatedByUserId')) {
            $entity->setUpdatedByUserId($this->getOAuth2Identity()['user_id']);
        }

        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function postUpdate(Base $entity)
    {
        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function preDelete(Base $entity)
    {
        // lets update the timestamps if possible
        //
        // *** careful we are assuming standard nameing conventions
        // *** assumption is the mother of all f*** ups
        if (method_exists($entity, 'setDeletedDate')) {
            $entity->setDeletedDate(new \DateTime());
        }

        if (method_exists($entity, 'setDeletedByUserId')) {
            $entity->setDeletedByUserId($this->getOAuth2Identity()['user_id']);
        }

        return true;
    }

    /**
    * @param Base $entity
    *
    * @return boolean
     */
    protected function postDelete(Base $entity)
    {
        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     *
    protected function preFetch(Base $entity)
    {
        return true;
    }

    /**
     * @param Base $entity
     *
     * @return boolean
     */
    protected function postFetch(Base $entity)
    {
        return true;
    }

    /**
     * (non-PHPdoc)
     * @see \Application\App\PersistenceInterface::create()
     */
    public function create(array $data)
    {
        $em = $this->getEntityManager();

        $em->getConnection()->beginTransaction();
        try {
            $entity = new $this->entityClass($data);

            if (!$this->preCreate($entity)) {
                throw new \Exception("Issue with pre create");
            }

            $em->persist($entity);

            if (!$this->postCreate($entity)) {
                throw new \Exception("Issue with post create");
            }

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return $entity->toArray();
    }

    /**
     * @param unknown $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $em = $this->getEntityManager();

        $em->getConnection()->beginTransaction();
        try {
            $entity = $em->find($this->entityClass, $id);

            if (!$this->preUpdate($entity)) {
                throw new \Exception("Issue with pre update");
            }

            $entity->set($data);

            $em->persist($entity);

            if (!$this->postUpdate($entity)) {
                throw new \Exception("Issue with post update");
            }

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return $entity->toArray();
    }

    /**
     * (non-PHPdoc)
     * @see \Application\App\PersistenceInterface::fetch()
     */
    public function fetch($id)
    {
        $repository = $this->getEntityManager()->getRepository($this->entityClass);
        $entity = $repository->findOneBy(['id' => $id]);

        if (!$this->postFetch($entity)) {
            throw new \Exception("Issue with post fetch");
        }

        return $entity->toArray();
    }

    /**
     * (non-PHPdoc)
     * @see \Application\App\PersistenceInterface::fetchAll()
     */
    public function fetchAll(array $data)
    {
        $entityManager = $this->getEntityManager();

        $entity = new $this->entityClass([]);
        $propertWhiteList = $entity->getPropertyWhiteList();

        $qb = $entityManager->createQueryBuilder();
        $qb->select(['e'])
           ->from($this->entityClass, 'e')
           ->where($qb->expr()->eq('e.deleted', '0'));

        // pass query builder to search filter which will be defined
        // in the child class if necessary
        $this->searchFilter($qb, $data);

        $query = $qb->getQuery()
                    ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);

        $adapter = new DoctrinePaginatorAdapter(
            new Paginator($query, false),
            $propertWhiteList[Base::PROPERTY_WHITE_LIST_TYPE_GET]
        );
        $paginator = new \Zend\Paginator\Paginator($adapter);

        return $paginator;
    }

    /**
     * (non-PHPdoc)
     * @see \Application\App\PersistenceInterface::delete()
     */
    public function delete($id)
    {
        $em = $this->getEntityManager();

        $em->getConnection()->beginTransaction();
        try {
            $entity = $em->find($this->entityClass, $id);

            if (!$this->preDelete($entity)) {
                throw new \Exception("Issue with pre delete");
            }

            $entity->setDeleted(1);

            $em->persist($entity);

            if (!$this->postDelete($entity)) {
                throw new \Exception("Issue with post delete");
            }

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            throw $e;
        }

        return true;
    }

    protected function getOAuth2Identity()
    {
        if ($this->oAuth2Identity !== null) {
            return $this->oAuth2Identity;
        }

        $request = Request::createFromGlobals();
        $server = $this->getOAuth2Server(null);
        $this->oAuth2Identity = $server->getAccessTokenData($request);

        return $this->oAuth2Identity;
    }

    /**
     * Retrieve the OAuth2\Server instance.
     *
     * If not already created by the composed $serverFactory, that callable
     * is invoked with the provided $type as an argument, and the value
     * returned.
     *
     * @param string $type
     * @return OAuth2Server
     * @throws RuntimeException if the factory does not return an OAuth2Server instance.
     */
    protected function getOAuth2Server($type)
    {
        if ($this->server instanceof Server) {
            return $this->server;
        }
        $server = call_user_func($this->serverFactory, $type);
        if (! $server instanceof Server) {
            throw new \RuntimeException(sprintf(
                'OAuth2\Server factory did not return a valid instance; received %s',
                (is_object($server) ? get_class($server) : gettype($server))
            ));
        }
        $this->server = $server;
        return $server;
    }

    /**
     * This is intended to be overidden by child class to apply entity specific filtering
     *
     * @param QueryBuilder $queryBuilder
     * @param array data
     *
     * @return void
     */
    protected function searchFilter(QueryBuilder &$queryBuilder, array $data) {}
}