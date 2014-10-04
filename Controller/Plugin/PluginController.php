<?php

namespace Nefarian\CmsBundle\Controller\Plugin;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PluginController extends Controller
{
    public function listAction()
    {
        $pluginManager = $this->get('nefarian_core.plugin_manager');

        return $this->render(
            'NefarianCmsBundle:Plugin:list.html.twig',
            array(
                'plugins' => $pluginManager->getPlugins(),
            )
        );
    }
} 