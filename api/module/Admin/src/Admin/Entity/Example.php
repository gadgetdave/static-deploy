<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * An example of how to implement a role aware user entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="example")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Example
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $exampleId = null;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name = null;

    public function toArray()
    {
        return array(
            'exampleId' => $this->getExampleId(),
            'name' => $this->getName(),
        );
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getExampleId()
    {
        return $this->exampleId;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setExampleId($exampleId)
    {
        $this->exampleId = (int) $exampleId;
        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function hydrateProperties(array $properties = [])
    {
        foreach ($properties as $key => $value) {
            if (method_exists($this, 'set' . $key)) {
                $this->{'set' . $key}($value);
            }
        }

        return $this;
    }
}
