<?php

namespace Nefarian\CmsBundle\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserManager
 *
 * @TODO: implement this!
 *
 * @package Nefarian\CmsBundle\User
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class UserManager
{
    public function hasPermission(UserInterface $user, $permission)
    {
        return true;
    }
} 
