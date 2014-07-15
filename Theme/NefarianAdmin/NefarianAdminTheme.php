<?php

namespace Nefarian\CmsBundle\Theme\NefarianAdmin;

use Nefarian\CmsBundle\Theme\Theme;

class NefarianAdminTheme extends Theme
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'nefarian_admin';
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        self::TYPE_ADMIN;
    }
} 
