<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RoutingController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class RoutingController extends Controller
{
    public function settingsAction()
    {
        $configManager = $this->get('nefarian_core.config_manager');
        $config        = $configManager->get('content_type.routing');

        $form = $this->createForm($config->getForm(), $config, array(
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_routing'),
            'attr' => array(
                'class' => 'api-save',
            ),
        ));

        return $this->render('@plugin_content_management/Routing/settings.html.twig', array(
            'form' => $form->createView(),
        ));
    }
} 
