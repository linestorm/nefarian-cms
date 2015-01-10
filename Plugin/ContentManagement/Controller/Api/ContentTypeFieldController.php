<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nefarian\CmsBundle\FosRest\View\View\JsonApiView;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeFieldForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
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
        return new ContentTypeFieldForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType';
    }

    public function postAction(Request $request, ContentType $contentType)
    {
        /** @var EntityManager $em */

        $fieldConfigForm = new ContentTypeFieldForm();
        $contentTypeField = new ContentTypeField();
        $contentTypeField->setContentType($contentType);

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $contentTypeField, array(
            'method' => 'POST',
        ));

        $label = $payload[$fieldConfigForm->getName()]['label'];
        $payload[$fieldConfigForm->getName()]['name']
               = strtolower(preg_replace(array('/[^a-zA-Z0-9 ]/', '/\s+/'), array('', '_'), $label));
        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            if ($entity instanceof ContentTypeField) {

                $fieldManager    = $this->get('nefarian_core.content_field_manager');
                $fieldDefinition = $fieldManager->getField($entity->getField()->getName());
                $configClass     = $fieldDefinition->getConfig();
                $defaultConfig   = new $configClass();
                $entity->setConfig($defaultConfig);

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $view = JsonApiView::create(null, 302, array(
                    'location' => $this->generateUrl('nefarian_api_content_management_post_type_field', array(
                        'contentType' => $contentType->getId(),
                    )),
                ));
            }
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    public function putSettingsAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $config          = clone $contentTypeField->getConfig();
        $fieldConfigForm = $config->getForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $config, array(
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

        if ($form->isValid()) {
            $entity = $form->getData();

            $contentTypeField->setConfig($entity);
            $em->persist($contentTypeField);
            $em->flush($contentTypeField);

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_content_type_edit_fields',
                    array('type' => $contentType->getName())),
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function putAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */

        $fieldConfigForm = new ContentTypeFieldForm();

        $payload = json_decode($request->getContent(), true);

        $form = $this->createForm($fieldConfigForm, $contentTypeField, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        $form->remove('field');

        $form->submit($payload[$fieldConfigForm->getName()]);

        if ($form->isValid()) {
            $entity = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $view = JsonApiView::create(null, 200, array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_content_type_edit_fields',
                    array('type' => $contentType->getName())),
            ));
        } else {
            $view = JsonApiView::create($form, 400);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function deleteAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->remove($contentTypeField);
        $em->flush();

        $view = JsonApiView::create(null, 204);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /*public function postAction(Request $request, ContentType $contentType, ContentTypeField $contentTypeField)
    {
        /** @var EntityManager $em * /
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

            $view = JsonApiView::create(null, 201, array(
                'location' => $this->generateUrl('nefarian_plugin_content_management_content_type_edit_fields', array('type' => $contentType->getName())),
            ));
        }
        else
        {
            $view = JsonApiView::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }*/


    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch ($method) {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_content_management_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_content_management_put_type', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_type',
                    array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_content_type_edit',
                    array('type' => $entity->getName()));
                break;
        }

        return '';
    }

    public function hasPermission($method)
    {
        $userManager = $this->get('nefarian_core.user_manager');
        switch ($method) {
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
