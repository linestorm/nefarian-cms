<?php

namespace Nefarian\CmsBundle\Theme\NefarianAdminDark;

use Nefarian\CmsBundle\Theme\Theme;

class NefarianAdminDarkTheme extends Theme
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'nefarian_admin_dark';
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        self::TYPE_ADMIN;
    }
} 
