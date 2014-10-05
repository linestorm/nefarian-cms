<?php

namespace Nefarian\CmsBundle\Controller\Plugin\Api;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\Exception\PluginNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PluginController extends Controller
{
    public function listAction()
    {
        $pluginManager = $this->get('nefarian_core.plugin_manager');

        $pluginList = array();
        foreach ($pluginManager->getPlugins() as $plugin) {
            $pluginList[] = array(
                'name'         => $plugin->getName(),
                'description'  => '@todo', // TODO
                'enabled'      => $pluginManager->isPluginEnabled($plugin),
                'dependencies' => $plugin->dependencies(),
            );
        }
        $view = new View($pluginList);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Enable a plugin
     *
     * @param Request $request
     */
    public function enablePluginAction(Request $request)
    {
        $pluginManager = $this->get('nefarian_core.plugin_manager');

        try {
            $payload    = $request->getContent();
            $payload    = json_decode($payload, true);
            $pluginName = $payload['name'];
        } catch (\Exception $e) {
            throw new BadRequestHttpException('Invalid Payload', $e);
        }

        try {
            $plugin = $pluginManager->getPlugin($pluginName);
            $pluginManager->enablePlugin($plugin);

            $view = new View(
                array(
                    'name'        => $plugin->getName(),
                    'description' => 'todo',
                    'enabled'     => true
                )
            );

            return $this->get('fos_rest.view_handler')->handle($view);
        } catch (PluginNotFoundException $e) {
            throw $this->createNotFoundException('Plugin not found', $e);
        }
    }
} 