<?php

namespace SuperAdmin\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use SuperAdmin\CoreBundle\Entity\Field;

/**
 * SuperAdmin\CoreBundle\Entity\Object
 *
 * @ORM\Table(name="object")
 * @ORM\Entity
 */
class Object
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=55)
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * 
     * @ORM\OneToMany(targetEntity="SuperAdmin\CoreBundle\Entity\Field", mappedBy="object", cascade={"all"}, orphanRemoval=true)
     */
    protected $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields(array $fields)
    {
        //remove all entity attached
        foreach($this->getFields() as $field){
            $field->setObject(null);
        }
        //clear
        $this->fields = new ArrayCollection();
        //add the new entity and attach them
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    public function addField(Field $field)
    {
        $field->setObject($this);
        $this->fields[] = $field;

        return $this;
    }

    public function removeField(Field $field)
    {
        $field->setObject(null);
        return $this;
    }

}
