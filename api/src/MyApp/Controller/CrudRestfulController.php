<?php
namespace MyApp\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Form\Element\Checkbox;
use Zend\Mvc\Controller\AbstractRestfulController;
use Doctrine\ORM\Query;

abstract class CrudRestfulController extends AbstractRestfulController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var unknown
     */
    protected $entity;

    /**
     * @var unknown
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $primaryKey;

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return CrudController
     */
    protected function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
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
        if ($this->entityManager === null) {
            $this->setEntityManager(
                    $this->getServiceLocator()->get('\Doctrine\ORM\EntityManager')
            );
        }

        return $this->entityManager;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractRestfulController::getList()
     */
    public function getList()
    {
        // Action used for GET requests without resource Id
        $repository = $this->getEntityManager()->getRepository(
            $this->entityClass
        );

        $items = [];
        foreach ($repository->findAll() as $row) {
            $items[] = $row->toArray();
        }

        $data = [
            'data' => $items
        ];

        return new JsonModel($data);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractRestfulController::get()
     */
    public function get($id)
    {
        // Action used for GET requests with resource Id
        $repository = $this->getEntityManager()->getRepository($this->entityClass);

        $entity = $repository->findOneBy([$this->identifierName => $id]);

        return new JsonModel(['data' => $entity->toArray()]);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractRestfulController::create()
     */
    public function create($data)
    {
        // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractRestfulController::update()
     */
    public function update($id, $data)
    {
        // Action used for GET requests with resource Id
        $em = $this->getEntityManager();

        $entity = $em->find($this->entityClass, $id)->hydrateProperties($data);

        $em->persist($entity);
        $em->flush();

        return new JsonModel(['data' => $entity->toArray()]);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractRestfulController::delete()
     */
    public function delete($id)
    {
        // Action used for DELETE requests
        return new JsonModel(array('data' => 'album id 3 deleted'));
    }
}