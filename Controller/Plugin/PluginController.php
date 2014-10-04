<?php

namespace Nefarian\CmsBundle\Controller\Plugin;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\Exception\PluginNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;

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

    /**
     * @param $name
     */
    public function enablePluginAction($name)
    {
        $pluginManager = $this->get('nefarian_core.plugin_manager');

        try
        {
            $plugin = $pluginManager->getPlugin($name);
            $pluginManager->enablePlugin($plugin);

            $view = new View(array(
                'enabled' => true
            ));
            return $this->get('fos_rest.view_handler')->handle($view);
        }
        catch(PluginNotFoundException $e)
        {
            throw $this->createNotFoundException('Plugin not found', $e);
        }
    }
} 