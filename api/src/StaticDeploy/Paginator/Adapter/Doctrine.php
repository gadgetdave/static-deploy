<?php

namespace StaticDeploy\Paginator\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Doctrine implements AdapterInterface
{
    protected $paginator;
    protected $count;

    protected $allowedProperties;

    /**
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator, array $allowedProperties = array())
    {
        $this->paginator = $paginator;
        $this->count = count($paginator);

        $this->allowedProperties = $allowedProperties;
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->paginator->getQuery()->setFirstResult($offset)
                                    ->setMaxResults($itemCountPerPage);

        $iterator = $this->paginator->getIterator();
        $flippedProperties = array_flip($this->allowedProperties);

        foreach ($iterator as &$row) {
            foreach ($row as $key => $value) {
                if (!array_key_exists($key, $flippedProperties)) {
                    unset($row[$key]);
                }
            }
        }

        return $iterator;
    }

    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count()
    {
        return $this->count;
    }
}