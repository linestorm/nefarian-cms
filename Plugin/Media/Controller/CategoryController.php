<?php

namespace Nefarian\CmsBundle\Plugin\Media\Controller;

use Nefarian\CmsBundle\Plugin\Media\Model\MediaCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AdminController
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Controller
 */
class CategoryController extends Controller
{

    /**
     * Edit a media entity
     *
     * @param $id
     *
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     * @return Response
     */
    public function editAction($id)
    {
        $user = $this->getUser();
        if(!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->get('linestorm.cms.model_manager');
        $repo         = $modelManager->get('media_category');

        $category = $repo->find($id);

        if(!($category instanceof MediaCategory))
        {
            throw $this->createNotFoundException("Media Category Not Found");
        }

        $form = $this->createForm('linestorm_cms_form_media_category', $category, array(
            'action' => $this->generateUrl('linestorm_cms_module_media_api_put_category', array('id' => $category->getId())),
            'method' => 'PUT',
        ));

        return $this->render('LineStormMediaBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
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
        if(!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->get('linestorm.cms.model_manager');
        $class        = $modelManager->getEntityClass('media_category');

        $form = $this->createForm('linestorm_cms_form_media_category', new $class(), array(
            'action' => $this->generateUrl('linestorm_cms_module_media_api_post_category'),
            'method' => 'POST',
        ));

        return $this->render('LineStormMediaBundle:Category:new.html.twig', array(
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
        } catch (MediaFileAlreadyExistsException $e)
        {
            $media = $e->getEntity();
            $code  = 200;
        } catch (\Exception $e)
        {
            $view = View::create(array(
                'error' => $e->getMessage(),
            ), 400);
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        }

        $api = array(
            'edit' => $this->generateUrl('linestorm_cms_module_media_api_put_media', array('id' => $media->getId())),
        );
        $doc = new \Nefarian\CmsBundle\Plugin\Media\Document\Media($media, $api);
        $view = View::create($doc, $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Upload an item for a entity we are editing
     *
     * @param $id
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function uploadEditAction($id)
    {
        $user = $this->getUser();
        if (!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $mediaManager = $this->get('linestorm.cms.media_manager');
        $image        = $mediaManager->find($id);

        if (!($image instanceof Media))
        {
            throw $this->createNotFoundException("Image Not Found");
        }

        $code = 201;
        try
        {
            $image = $this->doUpload($image);
        } catch (MediaFileAlreadyExistsException $e)
        {
            $code = 200;
        } catch (HttpException $e)
        {
            $view = View::create($e);
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        } catch (\Exception $e)
        {
            throw new HttpException(400, 'Upload Invalid', $e);
        }

        $view = View::create(new \Nefarian\CmsBundle\Plugin\Media\Document\Media($image), $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    /**
     * Handle a file upload
     *
     * @param Media|null $entity The entity to store into
     *
     * @return Media
     * @throws HttpException
     */
    private function doUpload($entity = null)
    {
        $mediaManager = $this->get('linestorm.cms.media_manager');

        $request = $this->getRequest();
        $files   = $request->files->all();

        $totalFiles = count($files);

        // only allow single uploads
        if ($totalFiles === 1)
        {
            /* @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
            $file = array_shift($files);

            if ($file->isValid())
            {
                $media = $mediaManager->store($file, $entity);

                if (!($media instanceof Media))
                {
                    throw new HttpException(400, 'Upload Invalid');
                }

                return $media;
            }
            else
            {
                switch ($file->getError())
                {
                    case UPLOAD_ERR_INI_SIZE:
                        throw new HttpException(400, 'Upload Invalid: File too large for server');
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new HttpException(400, 'Upload Invalid: File too large for form');
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        throw new HttpException(400, 'Upload Invalid: Only a partial file was recieved');
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new HttpException(400, 'Upload Invalid: No file given');
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        throw new HttpException(400, 'Upload Invalid: Unable to store (1)');
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        throw new HttpException(400, 'Upload Invalid: Unable to store (2)');
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        throw new HttpException(400, 'Upload Invalid: Invalid Extension');
                        break;
                }
            }
        }
        else
        {
            throw new HttpException(400, 'Upload Invalid: Too Many Files.');
        }
    }
}
