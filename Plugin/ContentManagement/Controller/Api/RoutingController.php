<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\RoutingConfigurationForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RoutingController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @FOSRest\RouteResource("Routing")
 */
class RoutingController extends Controller implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new RoutingConfigurationForm();
    }

    public function putAction(Request $request)
    {
        /** @var EntityManager $em */
        $configManager = $this->get('nefarian_core.config_manager');

        $fieldConfigName = 'content_type.routing';
        $fieldConfig     = $configManager->get($fieldConfigName);
        $fieldConfigForm = $fieldConfig->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $fieldConfig, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_routing'),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();
            $configManager->set($fieldConfigName, $entity);

            $view = View::create(array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_routing_settings'),
            ), 200);
        }
        else
        {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }
} 
