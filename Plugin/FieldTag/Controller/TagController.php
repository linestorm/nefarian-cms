<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Controller;

use Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\NodeTagForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TagController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagController extends Controller
{
    public function indexAction()
    {
        $em   = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('PluginFieldTag:NodeTag')->findAllRootTags();

        return $this->render('@plugin_field_tag/Tag/index.html.twig', array(
            'tags' => $tags,
        ));
    }


    /**
     * @param NodeTag $parentNodeTag
     * @return Response
     */
    public function newAction(NodeTag $parentNodeTag = null)
    {
        $tag = new NodeTag();

        if ($parentNodeTag instanceof NodeTag) {
            $tag->setParentTag($parentNodeTag);
        }

        $form = $this->createForm(new NodeTagForm(), $tag, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_field_tag_post_tag'),
        ));

        return $this->render('@plugin_field_tag/Tag/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(NodeTag $nodeTag)
    {
        $form = $this->createForm(new NodeTagForm(), $nodeTag, array(
            'attr' => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_field_tag_put_tag', array(
                'id' => $nodeTag->getId()
            )),
        ));

        $em      = $this->getDoctrine()->getManager();
        $parents = $em->getRepository('PluginFieldTag:NodeTag')->findAllParentTags($nodeTag);

        return $this->render('@plugin_field_tag/Tag/edit.html.twig', array(
            'tag' => $nodeTag,
            'parents' => $parents,
            'form' => $form->createView(),
        ));
    }


} 
