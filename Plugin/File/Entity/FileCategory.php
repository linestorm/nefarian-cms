<?php

namespace Nefarian\CmsBundle\Plugin\File\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\File\Model\FileCategory as BaseFileCategory;

/**
 * Class FileCategory
 *
 * @package Nefarian\CmsBundle\Plugin\File\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FileCategory extends BaseFileCategory
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var FileCategory[]
     *
     * @ORM\OneToMany(targetEntity="FileCategory", mappedBy="parent")
     */
    protected $children;

    /**
     * @var FileCategory
     *
     * @ORM\ManyToOne(targetEntity="FileCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var File
     *
     * @ORM\OneToMany(targetEntity="File", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $file;

} 
