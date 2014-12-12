<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeFieldForm;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('PluginContentManagement:ContentType')->findAll();

        return $this->render(
            '@plugin_content_management/ContentType/index.html.twig',
            array(
                'contentTypes' => $contentTypes,
            )
        );
    }

    /**
     * Create a form for a new content type
     *
     * @return Response
     */
    public function newAction()
    {
        $newContentType = new ContentType();

        $form = $this->createForm(
            new ContentTypeForm(),
            $newContentType,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'POST',
                'action' => $this->generateUrl('nefarian_api_content_management_post_type'),
            )
        );

        return $this->render(
            '@plugin_content_management/ContentType/new.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function editAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try {
            $contentType = $em->getRepository('PluginContentManagement:ContentType')->findWithFields($id);
        }
        catch (NoResultException $e) {
            throw $this->createNotFoundException('Content Type Not Found', $e);
        }

        $form = $this->createForm(
            new ContentTypeForm(),
            $contentType,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('nefarian_api_content_management_put_type',
                    array('id' => $contentType->getId())),
            )
        );

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-main.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

    public function editFieldDetailsAction(ContentTypeField $contentTypeField)
    {

        $form = $this->createForm(
            new ContentTypeFieldForm(),
            $contentTypeField,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('nefarian_api_content_management_put_type_field_details', array(
                    'contentType' => $contentTypeField->getContentType()->getId(),
                    'contentTypeField' => $contentTypeField->getId(),
                )),
            )
        );

        $form->remove('field');

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-details.html.twig',
            array(
                'contentType' => $contentTypeField->getContentType(),
                'contentTypeField' => $contentTypeField,
                'form' => $form->createView(),
            )
        );
    }

    public function editFieldsAction($id)
    {
        /** @var EntityManager $em */
        $em          = $this->getDoctrine()->getManager();
        $contentType = $em->getRepository('PluginContentManagement:ContentType')->find($id);

        if (!$contentType instanceof ContentType) {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        $form = $this->createForm(
            new ContentTypeForm(),
            $contentType,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('nefarian_api_content_management_put_type',
                    array('id' => $contentType->getId())),
            )
        );

        $fields = $em->getRepository('PluginContentManagement:Field')->findAll();

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-field.html.twig',
            array(
                'contentType' => $contentType,
                'fields' => $fields,
                'form' => $form->createView(),
            )
        );
    }

    public function createFieldsAction(Request $request, ContentType $contentType)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('field_name');
        $type = $request->request->get('field_type');

        $field = $em->getRepository('PluginContentManagement:Field')->find($type);

        if (!$field instanceof Field) {
            throw $this->createNotFoundException('Content Type Field not found');
        }

        // create a new field type
        $contentTypeField = new ContentTypeField();
        $contentTypeField->setName($name);
        $contentTypeField->setLabel($name);
        $contentTypeField->setField($field);
        $contentTypeField->setContentType($contentType);
        $contentTypeField->setOrder(count($contentType->getTypeFields()));

        // create a new field definition
        $fieldManager    = $this->get('nefarian_core.content_field_manager');
        $fieldDefinition = $fieldManager->getField($field->getName());
        $configClass     = $fieldDefinition->getConfig();
        $defaultConfig   = new $configClass();
        $contentTypeField->setConfig($defaultConfig);

        $em->persist($contentTypeField);
        $em->flush();

        return $this->redirect($this->generateUrl('nefarian_plugin_content_management_content_type_edit_field', array(
            'contentType' => $contentType->getId(),
            'contentTypeField' => $contentTypeField->getId(),
        )));
    }

    public function editFieldAction(ContentType $contentType, ContentTypeField $contentTypeField)
    {
        $config = $contentTypeField->getConfig();
        $form   = $config->getForm();

        $form = $this->createForm($form, $config, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_field', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-field-edit.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }
} 
