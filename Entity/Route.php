<?php

namespace Nefarian\CmsBundle\Entity;

use Nefarian\CmsBundle\Model\Route as BaseRoute;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Route
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="router")
 * @ORM\Entity
 */
class Route extends BaseRoute
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
} 
