<?php
namespace StaticDeploy\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Form\Element\Checkbox;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\Controller\AbstractController;

abstract class CrudController extends AbstractController
{
    use ControllerTrait;

    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_SEARCH = 'search';

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
    protected $entityForm;

    /**
     * @var unknown
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $viewConfig = [
        'title' => 'Page Title',
        'getItemsUrl' => 'search'
    ];


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
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction()
    {
        $repository = $this->getEntityManager()->getRepository(
            $this->entityClass
        );

        $items = [];
        foreach ($repository->findAll() as $row) {
            $items[] = $row->toArray();
        }

        $this->viewConfig[ViewConfig::ITEMS] = $items;

        return $this->returnNgView();
    }

    /**
     * @access public
     * @return array
     */
    public function searchAction()
    {
        $repository = $this->getEntityManager()->getRepository(
            $this->entityClass
        );

        $items = [];
        foreach ($repository->findAll() as $row) {
            $items[] = $row->toArray();
        }

        $data = [
            'items' => $items
        ];

        $this->layout('layout/output.phtml');
        return new JsonModel($data);

        return [
            'items' => $repository->findAll()
        ];
    }

    /**
     * @param string $forceFetch
     * @access protected
     * @return \StaticDeploy\Controller\unknown|boolean
     */
    protected function getEntity($forceFetch = false)
    {
        if (isset($this->entity) && !$forceFetch) {
            return $this->entity;
        }

        $entity = new $this->entityClass();

        /* if ($this->action != self::ACTION_CREATE) {
            $attemptFetch = true;
            $fetchBy = [];

            foreach ($primaryKeys AS $primaryKey) {
                if (!$this->getParam($primaryKey)) {
                    $attemptFetch = false;
                    break;
                }
                // prepend the primary key with the table alias to avoid
                // sql conflict in where clauses
                $fetchByKey = $tableAlias . '.' . $primaryKey;
                $fetchBy[$fetchByKey] = $this->getParam($primaryKey);
            }

            if ($attemptFetch && !$model->fetchBy($fetchBy)) {
                return false;
            }
        } */

        $this->entity = $entity;

        return $this->entity;

    }

    protected function getEntityForm()
    {
        return $this->getEntity()->getForm();
    }

    /**
     *
     */
    public function createAction()
    {
        $this->viewModel = new ViewModel();
        $em = $this->getEntityManager();

        $entity = $this->getEntity();
        /* $form = $this->getEntityForm();
        $form->bind($post); */
        $form = new Form();
        $form->add(new Checkbox('tick', ['label' => 'test']));


        $this->viewModel->setTemplate('form');
        $this->viewModel->setVariables([
            'form' => $form,
            'entity' => $entity
        ]);

        $this->layout('layout/output.phtml');

        return $this->viewModel;
    }

    public function viewAction()
    {
        $repository = $this->getEntityManager()->getRepository(
            $this->entityClass
        );

        $entity = $repository->findOneBy(['exampleId' => $this->getEvent()->getRouteMatch()->getParam('exampleId')]);

        $response = [];
        if (!empty($entity)) {
            $response = $entity->toArray();
        }

        return new JsonModel($response);
        die;
        dd();
        $items = [];
        foreach ($repository->findAll() as $row) {
            $items[] = $row->toArray();
        }

        $this->viewConfig[ViewConfig::ITEMS] = $items;

        return $this->returnNgView();
    }

    public function editAction()
    {
        return $this->updateAction();
    }

    public function updateAction()
    {
        return $this->createAction();
    }

    public function deleteAction()
    {

    }
}