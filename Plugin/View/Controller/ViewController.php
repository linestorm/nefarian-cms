<?php

namespace Nefarian\CmsBundle\Plugin\View\Controller;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\View\Form\ViewNewForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewController extends Controller
{
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $metaFactory = $em->getMetadataFactory();

        /** @var \Doctrine\ORM\Mapping\ClassMetadata[] $metaDatas */
        $metaDatas = $metaFactory->getAllMetadata();

        $form = $this->createForm(new ViewNewForm($metaDatas));

        return $this->render('@plugin_view/View/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
} 
