<?php

namespace StaticDeploy\Entity;

use Zend\Db\Sql\Ddl\Column\Datetime;

abstract class Base
{
    const PROPERTY_WHITE_LIST_TYPE_GET = 'get';
    const PROPERTY_WHITE_LIST_TYPE_SET = 'set';

    /**
     * @var array
     */
    protected $propertyWhiteList = [
        self::PROPERTY_WHITE_LIST_TYPE_GET => [],
        self::PROPERTY_WHITE_LIST_TYPE_SET => []
    ];

    public function __construct($data = [])
    {
        $data = (!empty($data) ? $data : []);

        $this->set($data);
    }

    /**
     * @return array
     */
    public function getPropertyWhiteList()
    {
        return $this->propertyWhiteList;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $vars = get_object_vars($this);
        unset(
            $vars['rawdata'],
            $vars['inputFilter'],
            $vars['propertyWhiteList'],
            $vars['__initializer__'],
            $vars['__cloner__'],
            $vars['__isInitialized__']
        );

        foreach ($vars as $property => $value) {
            // we only want to return the whitelist properties
            if (!array_key_exists(
                $property,
                array_flip($this->propertyWhiteList[self::PROPERTY_WHITE_LIST_TYPE_GET])
            )) {
                unset($vars[$property]);
                continue;
            }

            switch (true) {
                case $value instanceof \DateTime :
                    $vars[$property] = $value->format(\DateTime::ISO8601);
                    break;
                case is_object($value) :
                    $vars[$property] = $value->toArray();
                    break;
                default:
                    break;
            }
        }

        return $vars;
    }

    /**
     * Intended to be overridden in child class
     *
     * @access protected
     * @param array $data
     *
     * @return void
     */
    protected function preSet($data) {}

    /**
     * Intended to be overridden in child class
     *
     * @access protected
     * @param array $data
     *
     * @return void
     */
    protected function postSet($data) {}

    /**
     * Set multiple properties at once
     *
     * @access public
     * @param array $data
     *
     * @return void
     */
    public function set(array $data = array())
    {
        $this->preSet($data);

        if (!empty($data)) {
            $vars = get_class_vars(get_class($this));

            foreach ($data as $key => $val) {
                // we can only set properties in the whitelist
                if (!array_key_exists($key, array_flip($this->propertyWhiteList[self::PROPERTY_WHITE_LIST_TYPE_SET]))) {
                    continue;
                }

                if (is_array($val) && array_key_exists($key, $vars)) {
                    if (empty($this->$key)) {
                        $className = __NAMESPACE__ . "\\" . $key;
                        $val = new $className($val);
                    } else {
                        $obj = $this->$key;
                        $obj->set($val);
                        $val = $obj;
                    }
                }

                // we only want to set properties that
                // have a setter method - ie not 'id'
                if (method_exists($this, 'set' . ucfirst($key))) {
                    $this->$key = $val;
                }
            }
        }

        $this->postSet($data);
    }
}