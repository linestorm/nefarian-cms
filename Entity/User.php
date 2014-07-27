<?php

namespace Nefarian\CmsBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User extends BaseUser
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
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="user_user_groups")
     */
    protected $groups;

    function __toString()
    {
        return $this->username;
    }


}
