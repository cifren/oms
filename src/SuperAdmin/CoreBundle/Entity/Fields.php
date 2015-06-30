<?php

namespace SuperAdmin\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

}
