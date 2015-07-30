<?php
namespace StaticDeploy\Resource;

use PhlyRestfully\Exception\CreationException;
use PhlyRestfully\Exception\DomainException;
use PhlyRestfully\ResourceEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

abstract class AbstractResourceListener extends AbstractListenerAggregate
{
    /**
     * @var PersistenceInterface
     */
    protected $persistence;

    /**
     * @param PersistenceInterface $persistence
     */
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('create', array($this, 'onCreate'));
        $this->listeners[] = $events->attach('fetch', array($this, 'onFetch'));
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onFetchAll'));
        $this->listeners[] = $events->attach('update', array($this, 'onUpdate'));
        $this->listeners[] = $events->attach('delete', array($this, 'onDelete'));
    }

    /**
     * @param ResourceEvent $e
     */
    public function onCreate(ResourceEvent $e)
    {
        $data  = (array) $e->getParam('data');
        $paste = $this->persistence->create($data);
        if (!$paste) {
            throw new CreationException();
        }
        return $paste;
    }

    /**
     * @param ResourceEvent $e
     */
    public function onUpdate(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $data  = (array) $e->getParam('data');

        $paste = $this->persistence->update($id, $data);
        if (!$paste) {
            throw new CreationException();
        }
        return $paste;
    }

    /**
     * @param ResourceEvent $e
     */
    public function onDelete(ResourceEvent $e)
    {
        $id = $e->getParam('id');

        $paste = $this->persistence->delete($id);
        if (!$paste) {
            throw new CreationException();
        }
        return $paste;
    }

    /**
     * @param ResourceEvent $e
     */
    public function onFetch(ResourceEvent $e)
    {
        $id = $e->getParam('id');
        $paste = $this->persistence->fetch($id);
        if (!$paste) {
            throw new DomainException('Paste not found', 404);
        }
        return $paste;
    }

    /**
     * @param ResourceEvent $e
     */
    public function onFetchAll(ResourceEvent $e)
    {
        return $this->persistence->fetchAll($e->getQueryParams());
    }
}