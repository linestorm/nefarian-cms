<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Controller;

use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Plugin\FieldFile\Configuration\FieldFileConfiguration;
use Nefarian\CmsBundle\Plugin\File\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FileController extends Controller
{

    /**
     * Upload a media entity
     *
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $form = $request->query->get('form', null);

        if (!$form) {
            throw new BadRequestHttpException();
        }

        $configManager = $this->get('nefarian_core.config_manager');
        $mediaManager  = $this->get('nefarian.plugin.file.manager');

        /** @var FieldFileConfiguration $config */
        $config    = $configManager->get($form);
        $fileTypes = $config->getFileTypes();

        $files = array();
        $code  = 201;
        try {
            $request = $this->getRequest();

            /* @var $uploadFiles \Symfony\Component\HttpFoundation\File\UploadedFile[] */
            $uploadFiles = $request->files->all();

            foreach ($uploadFiles as $uploadedFile) {

                // TODO: validate file
                $provider = $mediaManager->getDefaultProviderInstance();
                if(!$provider->validateUpload($uploadedFile, $fileTypes))
                {
                    throw new UploadException("File type not allowed");
                }

                if ($uploadedFile->isValid()) {
                    $file = $mediaManager->upload($uploadedFile);

                    if (!$file instanceof File) {
                        throw new HttpException(400, 'Upload Invalid');
                    }

                    $files[] = $file;
                } else {
                    switch ($uploadedFile->getError()) {
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
        }
        catch (\Exception $e) {
            $view = View::create(array(
                'error' => $e->getMessage(),
            ), 400);
            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        };

        $docs = array();
        foreach ($files as $file) {
            $docs[] = new \Nefarian\CmsBundle\Plugin\File\Document\File($file/*, $api*/);
        }
        $view = View::create($docs, $code);
        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

}
