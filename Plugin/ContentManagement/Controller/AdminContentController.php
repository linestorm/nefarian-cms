<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminContentController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('NefarianPlugin:Contentmanagement:index.html.twig', array(

        ));
    }

} 
