<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Controller;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\FieldFile\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileController extends Controller
{

    /**
     * Upload a media entity
     *
     * @return Response
     */
    public function uploadAction()
    {
        $code = 201;
        try {
            $media = $this->doUpload();
        }
        catch (\Exception $e)
        {
            $view = View::create(array(
                'error' => $e->getMessage(),
            ), 400);
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        };

//        $api = array(
//            'create' => $this->generateUrl('linestorm_cms_module_media_api_post_media'),
//        );
//        $doc = new \Nefarian\CmsBundle\Plugin\Media\Document\Media($media, $api);
        $view = View::create($media, $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * Handle a file upload
     *
     * @param File|null $entity The entity to store into
     *
     * @return File[]
     * @throws HttpException
     */
    private function doUpload($entity = null)
    {
        $mediaManager = $this->get('nefarian.plugin.media.manager');

        $request = $this->getRequest();

        /* @var $files \Symfony\Component\HttpFoundation\File\UploadedFile[] */
        $files   = $request->files->all();

        $fileEntities = array();
        foreach($files as $file)
        {
            if ($file->isValid())
            {
                $file = $mediaManager->upload($file, $entity);

                if (!$file instanceof File)
                {
                    throw new HttpException(400, 'Upload Invalid');
                }

                $fileEntities[] = $file;
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

        return $fileEntities;
    }

}
