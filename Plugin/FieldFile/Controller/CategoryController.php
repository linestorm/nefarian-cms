<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Controller;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\NodeForm;
use Nefarian\CmsBundle\Plugin\FieldFile\Entity\NodeCategory;
use Nefarian\CmsBundle\Plugin\FieldFile\Form\NodeCategoryForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CategoryController extends Controller
{
    public function indexAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('PluginFieldFile:NodeCategory')->findAll();

        return $this->render('@plugin_field_file/Category/index.html.twig', array(
            'categories' => $categories,
        ));
    }


    /**
     * @throws NotFoundHttpException
     *
     * @return Response
     */
    public function newAction()
    {
        $category = new NodeCategory();

        $form = $this->createForm(new NodeCategoryForm(), $category, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_field_file_post_category'),
        ));

        return $this->render('@plugin_field_file/Category/new.html.twig', array(
            'form'        => $form->createView(),
        ));
    }

    public function editAction(NodeCategory $nodeCategory)
    {
        $form = $this->createForm(new NodeCategoryForm(), $nodeCategory, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_field_file_put_category', array(
                'id' => $nodeCategory->getId()
            )),
        ));

        return $this->render('@plugin_field_file/Category/edit.html.twig', array(
            'category' => $nodeCategory,
            'form' => $form->createView(),
        ));
    }


} 
