<?php

namespace Nefarian\CmsBundle\Plugin\File\Controller;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\File\File\Exception\FileFileAlreadyExistsException;
use Nefarian\CmsBundle\Plugin\File\Model\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class FileController
 *
 * @package Nefarian\CmsBundle\Plugin\File\Controller
 */
class FileController extends Controller
{

    /**
     * List all file items
     *
     * @return Response
     * @throws AccessDeniedException
     */
    public function listAction()
    {
        // get all the files

        $userManager = $this->get('nefarian_core.user_manager');
        $userManager->hasPermission($this->getUser(), 'file.view');

        $fileManager = $this->get('nefarian.plugin.file.manager');

        $providers = $fileManager->getFileProviders();

        return $this->render('@plugin_file/Admin/list.html.twig', array(
            'providers' => $providers,
        ));

    }

    /**
     * Edit a file entity
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

        $fileManager = $this->get('linestorm.cms.file_manager');
        $provider     = $fileManager->getDefaultProviderInstance();

        $file = $fileManager->find($id);

        $form = $this->createForm($provider->getForm(), $file, array(
            'action' => $this->generateUrl('linestorm_cms_module_file_api_put_file', array('id' => $file->getId())),
            'method' => 'PUT',
        ));

        return $this->render('LineStormFileBundle:Admin:edit.html.twig', array(
            'image' => $file,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Create a file entity
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

        $fileManager = $this->get('linestorm.cms.file_manager');
        $provider     = $fileManager->getDefaultProviderInstance();
        $class = $provider->getEntityClass();

        $form = $this->createForm('linestorm_cms_form_file_multiple', null, array(
            'action' => $this->generateUrl('linestorm_cms_module_file_api_post_file_batch'),
            'method' => 'POST',
        ));

        return $this->render('LineStormFileBundle:Admin:new.html.twig', array(
            'image' => null,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Upload a file entity
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
            $file = $this->doUpload();
        }
        catch (FileFileAlreadyExistsException $e)
        {
            $file = $e->getEntity();
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
            'create' => $this->generateUrl('linestorm_cms_module_file_api_post_file'),
        );
        $doc = new \Nefarian\CmsBundle\Plugin\File\Document\File($file, $api);
        $view = View::create($doc, $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
