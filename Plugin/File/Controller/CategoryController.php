<?php

namespace Nefarian\CmsBundle\Plugin\File\Controller;

use Nefarian\CmsBundle\Plugin\File\Model\FileCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AdminController
 *
 * @package Nefarian\CmsBundle\Plugin\File\Controller
 */
class CategoryController extends Controller
{

    /**
     * Edit a file entity
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

        $modelManager = $this->get('nefarian.plugin.file.manager');
        $repo         = $modelManager->get('file_category');

        $category = $repo->find($id);

        if(!($category instanceof FileCategory))
        {
            throw $this->createNotFoundException("File Category Not Found");
        }

        $form = $this->createForm('linestorm_cms_form_file_category', $category, array(
            'action' => $this->generateUrl('linestorm_cms_module_file_api_put_category', array('id' => $category->getId())),
            'method' => 'PUT',
        ));

        return $this->render('LineStormFileBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
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
        if(!($user instanceof UserInterface) || !($user->hasGroup('admin')))
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->get('nefarian.plugin.file.manager');
        $class        = $modelManager->getEntityClass('file_category');

        $form = $this->createForm('linestorm_cms_form_file_category', new $class(), array(
            'action' => $this->generateUrl('linestorm_cms_module_file_api_post_category'),
            'method' => 'POST',
        ));

        return $this->render('LineStormFileBundle:Category:new.html.twig', array(
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
        } catch (FileFileAlreadyExistsException $e)
        {
            $file = $e->getEntity();
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
            'edit' => $this->generateUrl('linestorm_cms_module_file_api_put_file', array('id' => $file->getId())),
        );
        $doc = new \Nefarian\CmsBundle\Plugin\File\Document\File($file, $api);
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

        $fileManager = $this->get('nefarian.plugin.file.manager');
        $image        = $fileManager->find($id);

        if (!($image instanceof File))
        {
            throw $this->createNotFoundException("Image Not Found");
        }

        $code = 201;
        try
        {
            $image = $this->doUpload($image);
        } catch (FileFileAlreadyExistsException $e)
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

        $view = View::create(new \Nefarian\CmsBundle\Plugin\File\Document\File($image), $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }


    /**
     * Handle a file upload
     *
     * @param File|null $entity The entity to store into
     *
     * @return File
     * @throws HttpException
     */
    private function doUpload($entity = null)
    {
        $fileManager = $this->get('nefarian.plugin.file.manager');

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
                $file = $fileManager->store($file, $entity);

                if (!($file instanceof File))
                {
                    throw new HttpException(400, 'Upload Invalid');
                }

                return $file;
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
