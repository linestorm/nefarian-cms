<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContentTypeController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 *
 * @FOSRest\RouteResource("Field")
 */
class ContentTypeFieldController extends Controller implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new ContentTypeForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType';
    }

    public function putAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $configManager = $this->get('nefarian_core.config_manager');

        $fieldConfigName = 'content_type.' . $contentType->getName() . '.' . $contentTypeField->getName();
        $fieldConfig     = $configManager->get($fieldConfigName);
        $fieldConfigForm = $fieldConfig->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $fieldConfig, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();
            $configManager->set($fieldConfigName, $entity);

            $view = View::create(null, 200, array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_content_type_edit_fields', array('id' => $contentType->getId())),
            ));
        }
        else
        {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function deleteAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $configManager = $this->get('nefarian_core.config_manager');

        $fieldConfigName = 'content_type.' . $contentType->getName() . '.' . $contentTypeField->getName();
        $configManager->delete($fieldConfigName);

        $em->remove($contentTypeField);
        $em->flush();

        $view = View::create(null, 204);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function postAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $configManager = $this->get('nefarian_core.config_manager');

        $fieldConfigName = 'content_type.' . $contentType->getName() . '.' . $contentTypeField->getName();
        $fieldConfig     = $configManager->get($fieldConfigName);
        $fieldConfigForm = $configManager->getConfigForm($fieldConfigName);

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $fieldConfig, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->submit($payload[$fieldConfigForm->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();
            $configManager->set($fieldConfigName, $entity);

            $view = View::create(null, 201, array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_content_type_edit_fields', array('id' => $contentType->getId())),
            ));
        }
        else
        {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_content_management_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_content_management_put_type', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_type', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_content_type_edit', array( 'id' => $entity->getId() ));
                break;
        }

        return '';
    }

    public function hasPermission($method)
    {
        $userManager = $this->get('nefarian_core.user_manager');
        switch($method)
        {
            case self::METHOD_NEW:
            case self::METHOD_POST:
                return $userManager->hasPermission($this->getUser(), 'content.type.create');
                break;

            case self::METHOD_EDIT:
            case self::METHOD_PUT:
                return $userManager->hasPermission($this->getUser(), 'content.type.update');
                break;

            case self::METHOD_DELETE:
                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
                break;

            case self::METHOD_GET:
                return $userManager->hasPermission($this->getUser(), 'content.type.get');
                break;
        }

        return false;
    }

} 
