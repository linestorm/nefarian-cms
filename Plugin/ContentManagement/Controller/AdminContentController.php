<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminContentController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('@plugin_content_management/index.html.twig', array(

        ));
    }

} 
