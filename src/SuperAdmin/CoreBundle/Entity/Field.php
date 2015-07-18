<?php

namespace SuperAdmin\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SuperAdmin\CoreBundle\Entity\Object;

/**
 * SuperAdmin\CoreBundle\Entity\Field
 *
 * @ORM\Table(name="field")
 * @ORM\Entity
 */
class Field
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="type", type="string", length=55)
     */
    protected $type;

    /**
     * @ORM\Column(name="label", type="string", length=255)
     */
    protected $label;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="required", type="boolean", nullable=true)
     */
    protected $required;

    /**
     * @ORM\Column(name="default_value", type="text", nullable=true)
     */
    protected $defaultValue;

    /**
     * @ORM\Column(name="placeholder", type="text", nullable=true)
     */
    protected $placeholder;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="SuperAdmin\CoreBundle\Entity\Object", inversedBy="fields")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id")
     */
    protected $object;

    public function __toString()
    {
        return $this->getLabel() ? $this->getLabel() : 'no label';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject(Object $object = null)
    {
        $this->object = $object;
        return $this;
    }

}
