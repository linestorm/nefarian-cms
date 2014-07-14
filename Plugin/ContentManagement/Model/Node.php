<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Node
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class Node
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $published;

    /**
     * @var \DateTime
     */
    protected $publishedOn;

    /**
     * @var UserInterface
     */
    protected $publishedBy;

    /**
     * @var \DateTime
     */
    protected $createdOn;

    /**
     * @var UserInterface
     */
    protected $createdBy;

    /**
     * @var boolean
     */
    protected $deleted = false;

    /**
     * @var UserInterface
     */
    protected $deletedBy;

    /**
     * @var \DateTime
     */
    protected $deletedOn;

    /**
     * @var UserInterface
     */
    protected $editedBy;

    /**
     * @var \DateTime
     */
    protected $editedOn;

} 
