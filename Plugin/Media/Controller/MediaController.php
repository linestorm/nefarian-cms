<?php

namespace Nefarian\CmsBundle\Plugin\Media\Controller;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\Media\Media\Exception\MediaFileAlreadyExistsException;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MediaController
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Controller
 */
class MediaController extends Controller
{

    /**
     * List all media items
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function listAction()
    {
        $userManager = $this->get('nefarian_core.user_manager');
        $userManager->hasPermission($this->getUser(), 'media.view');

        $mediaManager = $this->get('nefarian.plugin.media.manager');

        $providers = $mediaManager->getMediaProviders();

        return $this->render('@plugin_media/Admin/list.html.twig', array(
            'providers' => $providers,
        ));

    }

    /**
     * Edit a media entity
     *
     * @param $id
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function editAction($id)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $mediaManager = $this->get('linestorm.cms.media_manager');
        $provider     = $mediaManager->getDefaultProviderInstance();

        $media = $mediaManager->find($id);

        $form = $this->createForm($provider->getForm(), $media, array(
            'action' => $this->generateUrl('linestorm_cms_module_media_api_put_media', array('id' => $media->getId())),
            'method' => 'PUT',
        ));

        return $this->render('LineStormMediaBundle:Admin:edit.html.twig', array(
            'image' => $media,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Create a media entity
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function newAction()
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $mediaManager = $this->get('linestorm.cms.media_manager');
        $provider     = $mediaManager->getDefaultProviderInstance();
        $class = $provider->getEntityClass();

        $form = $this->createForm('linestorm_cms_form_media_multiple', null, array(
            'action' => $this->generateUrl('linestorm_cms_module_media_api_post_media_batch'),
            'method' => 'POST',
        ));

        return $this->render('LineStormMediaBundle:Admin:new.html.twig', array(
            'image' => null,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Upload a media entity
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function uploadAction()
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $code = 201;
        try
        {
            $media = $this->doUpload();
        }
        catch (MediaFileAlreadyExistsException $e)
        {
            $media = $e->getEntity();
            $code  = 200;
        }
        catch (\Exception $e)
        {
            $view = View::create(array(
                'error' => $e->getMessage(),
            ), 400);
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        };

        $api = array(
            'create' => $this->generateUrl('linestorm_cms_module_media_api_post_media'),
        );
        $doc = new \Nefarian\CmsBundle\Plugin\Media\Document\Media($media, $api);
        $view = View::create($doc, $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
