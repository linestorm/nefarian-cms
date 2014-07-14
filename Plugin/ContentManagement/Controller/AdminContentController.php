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
        return $this->render('@ContentManagementPlugin/index.html.twig', array(

        ));
    }

} 
