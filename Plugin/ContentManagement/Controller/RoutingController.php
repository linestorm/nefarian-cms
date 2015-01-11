<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Doctrine\ORM\EntityManager;
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
        $config        = $configManager->get('routing.settings');

        $form = $this->createForm($config->getForm(), $config, array(
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_routing'),
            'attr' => array(
                'class' => 'api-save',
            ),
        ));

        return $this->render('@plugin_content_management/Routing/tab-settings.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function routesAction()
    {
        return $this->render('@plugin_content_management/Routing/tab-routes.html.twig');
    }


    public function manageAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        return $this->render('@plugin_content_management/Routing/tab-manage.html.twig', array(

        ));
    }
} 
