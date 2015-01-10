<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeFieldForm;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeFormViewForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

    /**
     * @param ContentType $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editAction(ContentType $contentType)
    {
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
            '@plugin_content_management/ContentType/edit-tab-content-type.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editFieldsAction(ContentType $contentType)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $contentTypeFieldForm = new ContentTypeFieldForm();
        $contentTypeFields = new ContentTypeField();
        $contentTypeFields->setOrder(count($contentType->getTypeFields()));
        $form = $this->createForm($contentTypeFieldForm, $contentTypeFields, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_content_management_post_type_field', array(
                'contentType' => $contentType->getId(),
            )),
        ));

        $form->remove('name');

        $fields = $em->getRepository('PluginContentManagement:Field')->findAll();

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-fields.html.twig',
            array(
                'contentType' => $contentType,
                'fields' => $fields,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function editFieldAction(ContentType $contentType, ContentTypeField $contentTypeField)
    {
        $form = $this->createForm(
            new ContentTypeFieldForm(),
            $contentTypeField,
            array(
                'attr' => array(
                    'class' => 'api-save'
                ),
                'method' => 'PUT',
                'action' => $this->generateUrl('nefarian_api_content_management_put_type_field', array(
                    'contentType' => $contentType->getId(),
                    'contentTypeField' => $contentTypeField->getId(),
                )),
            )
        );

        $form->remove('field');

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-field-edit.html.twig',
            array(
                'contentType' => $contentTypeField->getContentType(),
                'contentTypeField' => $contentTypeField,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     * @param ContentTypeField $contentTypeField
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     * @ParamConverter("contentTypeField", options={"mapping": {"typeField" = "name"}})
     */
    public function editFieldSettingsAction(ContentType $contentType, ContentTypeField $contentTypeField)
    {
        $config = $contentTypeField->getConfig();
        $form   = $config->getForm();

        $form = $this->createForm($form, $config, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_field_settings', array(
                'contentType' => $contentType->getId(),
                'contentTypeField' => $contentTypeField->getId(),
            )),
        ));

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-field-settings.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @param ContentType      $contentType
     *
     * @return Response
     *
     * @ParamConverter("contentType", options={"mapping": {"type" = "name"}})
     */
    public function editFormViewAction(ContentType $contentType)
    {
        $form = $this->createForm(new ContentTypeFormViewForm(), $contentType, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type_form_view', array(
                'id' => $contentType->getId(),
            )),
        ));

        return $this->render(
            '@plugin_content_management/ContentType/edit-tab-form-view.html.twig',
            array(
                'contentType' => $contentType,
                'form' => $form->createView(),
            )
        );
    }

} 
