<?php
namespace Application\Resource\OAuthClient;

use StaticDeploy\Resource\AbstractResourceListener;

class ResourceListener extends AbstractResourceListener
{
    /**
     * (non-PHPdoc)
     * @see \Zend\EventManager\ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('create', array($this, 'onCreate'));
    }
}