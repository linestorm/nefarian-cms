<?php

namespace Nefarian\CmsBundle;

use Nefarian\CmsBundle\DependencyInjection\Compiler\PluginCompilerPass;
use Nefarian\CmsBundle\DependencyInjection\Compiler\ThemeCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class NefarianCmsBundle
 *
 * @package Nefarian\CmsBundle
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NefarianCmsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PluginCompilerPass());
        $container->addCompilerPass(new ThemeCompilerPass());
    }
}
