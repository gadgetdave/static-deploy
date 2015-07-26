<?php

namespace MyApp\Paginator\Adapter;

use Zend\Paginator\Adapter\AdapterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Doctrine implements AdapterInterface
{
    protected $paginator;
    protected $count;

    /**
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
        $this->count = count($paginator);
    }

    /**
     * (non-PHPdoc)
     * @see \Zend\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->paginator->getQuery()->setFirstResult($offset)
                                    ->setMaxResults($itemCountPerPage);

        return $this->paginator->getIterator();
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