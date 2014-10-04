<?php

namespace Nefarian\CmsBundle\Controller\Plugin\Api;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\Exception\PluginNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PluginController extends Controller
{
    /**
     * Enable a plugin
     *
     * @param Request $request
     */
    public function enablePluginAction(Request $request)
    {
        $pluginManager = $this->get('nefarian_core.plugin_manager');

        try
        {
            $payload = $request->getContent();
            $payload = json_decode($payload, true);
            $pluginName = $payload['name'];
        }
        catch(\Exception $e)
        {
            throw new BadRequestHttpException('Invalid Payload', $e);
        }

        try {
            $plugin = $pluginManager->getPlugin($pluginName);
            $pluginManager->enablePlugin($plugin);

            $view = new View(
                array(
                    'enabled' => true
                )
            );

            return $this->get('fos_rest.view_handler')->handle($view);
        } catch (PluginNotFoundException $e) {
            throw $this->createNotFoundException('Plugin not found', $e);
        }
    }
} 