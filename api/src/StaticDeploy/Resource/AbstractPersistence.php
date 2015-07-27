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

    public function __construct(EntityManager $em)
    {
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

        /**
         * @todo add user create set methods here when we have users set up
         */

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

        /**
         * @todo add user create set methods here when we have users set up
         */

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
            $entity->setUpdatedDate(new \DateTime());
        }

        /**
         * @todo add user delete set methods here when we have users set up
         */

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
    public function fetchAll()
    {
        $entityManager = $this->getEntityManager();

        $entity = new $this->entityClass([]);
        $propertWhiteList = $entity->getPropertyWhiteList();

        /* $dql = "SELECT e." . implode(', e.', $propertWhiteList[Base::PROPERTY_WHITE_LIST_TYPE_GET])
             . " FROM " . $this->entityClass . ' e WHERE e.deleted = 0'; */

        $qb = $entityManager->createQueryBuilder();
        $qb->select(['e'])
            ->from($this->entityClass, 'e')
            ->where($qb->expr()->eq('e.deleted', '0'));

        $query = $qb->getQuery()
                    ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);
        /* $query = $entityManager->createQuery($dql)
                               ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY); */

        $adapter = new DoctrinePaginatorAdapter(new Paginator($query, false), $propertWhiteList[Base::PROPERTY_WHITE_LIST_TYPE_GET]);
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
}