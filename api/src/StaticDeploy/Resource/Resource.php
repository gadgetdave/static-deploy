<?php

namespace StaticDeploy\Resource;

use \PhlyRestfully\HalCollection;
use \PhlyRestfully\ApiProblem;

class Resource extends \PhlyRestfully\Resource
{
    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::create()
     */
    public function create($data)
    {
        if (is_array($data)) {
            $data = (object) $data;
        }
        if (!is_object($data)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Data provided to create must be either an array or object; received "%s"',
                gettype($data)
            ));
        }

        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, array('data' => $data));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();
        if (!is_array($last) && !is_object($last)) {
            return $data;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::update()
     */
    public function update($id, $data)
    {
        if (is_array($data)) {
            $data = (object) $data;
        }
        if (!is_object($data)) {
            throw new Exception\InvalidArgumentException(sprintf(
                    'Data provided to update must be either an array or object; received "%s"',
                    gettype($data)
            ));
        }

        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, compact('id', 'data'));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });

        $last    = $results->last();
        if (!is_array($last) && !is_object($last)) {
            return $data;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::replaceList()
     */
    public function replaceList($data)
    {
        if (!is_array($data)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Data provided to replaceList must be either a multidimensional array or array of objects; received "%s"',
                gettype($data)
            ));
        }
        array_walk($data, function($value, $key) use(&$data) {
            if (is_array($value)) {
                $data[$key] = (object) $value;
                return;
            }

            if (!is_object($value)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Data provided to replaceList must contain only arrays or objects; received "%s"',
                    gettype($value)
                ));
            }
        });
        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, array('data' => $data));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();
        if (!is_array($last) && !is_object($last)) {
            return $data;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::patch()
     */
    public function patch($id, $data)
    {
        if (is_array($data)) {
            $data = (object) $data;
        }
        if (!is_object($data)) {
            throw new Exception\InvalidArgumentException(sprintf(
                    'Data provided to create must be either an array or object; received "%s"',
                    gettype($data)
            ));
        }

        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, compact('id', 'data'));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();
        if (!is_array($last) && !is_object($last)) {
            return $data;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::delete()
     */
    public function delete($id)
    {
        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, array('id' => $id));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();
        if (!is_bool($last) && !$last instanceof ApiProblem) {
            return false;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::deleteList()
     */
    public function deleteList($data = null)
    {
        if ($data
            && (!is_array($data) && !$data instanceof Traversable)
        ) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects a null argument, or an array/Traversable of items and/or ids; received %s',
                __METHOD__,
                gettype($data)
            ));
        }
        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, array('data' => $data));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();
        if (!is_bool($last) && !$last instanceof ApiProblem) {
            return false;
        }
        return $last;
    }

    /**
     * (non-PHPdoc)
     * @see \PhlyRestfully\Resource::fetch()
     */
    public function fetch($id)
    {
        $events  = $this->getEventManager();
        $event   = $this->prepareEvent(__FUNCTION__, array('id' => $id));
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });

        $last    = $results->last();
        if (!is_array($last) && !is_object($last)) {
            return false;
        }
        return $last;
    }

    /**
     * Fetch a collection of items
     *
     * Use to retrieve a collection of items. The value of the last
     * listener will be returned, as long as it is an array or Traversable;
     * otherwise, an empty array will be returned.
     *
     * The recommendation is to return a \Zend\Paginator\Paginator instance,
     * which will allow performing paginated sets, and thus allow the view
     * layer to select the current page based on the query string or route.
     *
     * @return array|Traversable
     */
    public function fetchAll()
    {
        $events  = $this->getEventManager();
        $params  = func_get_args();
        $event   = $this->prepareEvent(__FUNCTION__, $params);
        $results = $events->trigger($event, function($result) {
            return $result instanceof ApiProblem;
        });
        $last    = $results->last();

        if (!is_array($last)
                && !$last instanceof HalCollection
                && !$last instanceof ApiProblem
                && !$last instanceof \Traversable
        ) {
            return array();
        }
        return $last;
    }
}