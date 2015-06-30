<?php

namespace SuperAdmin\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

}
