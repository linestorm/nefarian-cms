<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Controller;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\NodeForm;
use Nefarian\CmsBundle\Plugin\FieldCategory\Entity\NodeCategory;
use Nefarian\CmsBundle\Plugin\FieldCategory\Form\NodeCategoryForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldCategory\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CategoryController extends Controller
{
    public function indexAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('PluginFieldCategory:NodeCategory')->findAll();

        return $this->render('@plugin_field_category/Category/index.html.twig', array(
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
            'action' => $this->generateUrl('nefarian_api_field_category_post_category'),
        ));

        return $this->render('@plugin_field_category/Category/new.html.twig', array(
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
            'action' => $this->generateUrl('nefarian_api_field_category_put_category', array(
                'id' => $nodeCategory->getId()
            )),
        ));

        return $this->render('@plugin_field_category/Category/edit.html.twig', array(
            'category' => $nodeCategory,
            'form' => $form->createView(),
        ));
    }


} 
