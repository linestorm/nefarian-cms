<?php

namespace Nefarian\CmsBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Node
 *
 * @package Nefarian\CmsBundle\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentNode
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
    protected $deleted;

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
