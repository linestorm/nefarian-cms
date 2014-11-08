<?php

namespace Nefarian\CmsBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Route
 *
 * @package Nefarian\CmsBundle\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class Route
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=True, nullable=False)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=True, nullable=False)
     */
    protected $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=True, nullable=False)
     */
    protected $pattern;

    /**
     * @var \Symfony\Component\Routing\Route
     *
     * @ORM\Column(type="object", nullable=False)
     */
    protected $route;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return \Symfony\Component\Routing\Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

}
