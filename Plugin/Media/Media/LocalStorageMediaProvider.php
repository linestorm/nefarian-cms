<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Nefarian\CmsBundle\Plugin\Media\Media\Exception\MediaFileDeniedException;
use Nefarian\CmsBundle\Plugin\Media\Media\Exception\MediaFileNotFoundException;
use Nefarian\CmsBundle\Plugin\Media\Media\Optimiser\OptimiseProfileInterface;
use Nefarian\CmsBundle\Plugin\Media\Media\Resizer\ImageResize;
use Nefarian\CmsBundle\Plugin\Media\Media\Resizer\MediaResizeProfileManager;
use Nefarian\CmsBundle\Plugin\Media\Model\Media;
use Nefarian\CmsBundle\Plugin\Media\Model\MediaResizeProfile;
use Nefarian\CmsBundle\Plugin\Media\Model\MediaVersion;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Local storage media provider. This provider will store all images on the local disk.
 *
 * Class LocalStorageMediaProvider
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Media
 */
class LocalStorageMediaProvider extends AbstractMediaProvider implements MediaProviderInterface
{
    /**
     * @var string
     */
    protected $id = 'local_storeage';

    /**
     * @var string
     */
    protected $form = 'linestorm_cms_form_media';

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var UserInterface|null
     */
    protected $user;

    /**
     * @var OptimiseProfileInterface
     */
    protected $optimiser;

    /**
     * Mime types that are accepted
     *
     * @var array
     */
    private $accept = array(
        'image/jpeg' => array('jpg', 'jpeg'),
        'image/png'  => array('png'),
        'image/gif'  => array('gif'),
    );

    /**
     * Where the files are stored in the web folder
     *
     * @var string
     */
    private $storeDirectory;

    /**
     * This is the local path to the web folder
     *
     * @var string
     */
    private $storePath;

    /**
     * @var MediaResizeProfileManager
     */
    protected $mediaResizeProfileManager;

    /**
     * @param EntityManager                     $em         The Entity Manager to use
     * @param string                            $mediaClass The Entity class
     * @param SecurityContext                   $secutiryContext
     * @param Resizer\MediaResizeProfileManager $mediaResizeProfileManager
     * @param string                            $path
     * @param string                            $src
     */
    function __construct(EntityManager $em, $mediaClass, SecurityContext $secutiryContext, MediaResizeProfileManager $mediaResizeProfileManager, $path, $src)
    {
        $this->em                        = $em;
        $this->class                     = $mediaClass;
        $this->mediaResizeProfileManager = $mediaResizeProfileManager;
        $this->storePath                 = realpath($path) . DIRECTORY_SEPARATOR;
        $this->storeDirectory            = $src;

        $token = $secutiryContext->getToken();
        if($token)
        {
            $this->user = $token->getUser();
        }
    }

    /**
     * Set the entity manager
     *
     * @param EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Return the entity class FQNS
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->class;
    }

    /**
     * Return the categoryentity class FQNS
     *
     * @return string
     */
    public function getCategoryEntityClass()
    {
        return $this->class . "Category";
    }

    /**
     * Return the version entity class FQNS
     *
     * @return string
     */
    public function getVersionEntityClass()
    {
        return $this->class . "Version";
    }

    /**
     * @return string
     */
    public function getStorePath()
    {
        return $this->storePath;
    }

    /**
     * @return string
     */
    public function getStoreDirectory()
    {
        return $this->storeDirectory;
    }



    /**
     * @param OptimiseProfileInterface $optimiser
     */
    public function setOptimiser(OptimiseProfileInterface $optimiser)
    {
        $this->optimiser = $optimiser;
    }

    /**
     * @return OptimiseProfileInterface
     */
    public function getOptimiser()
    {
        return $this->optimiser;
    }



    /**
     * @inheritdoc
     */
    public function find($id)
    {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @inheritdoc
     */
    public function findByHash($hash)
    {
        return $this->em->getRepository($this->class)->findOneBy(array('hash' => $hash));
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $criteria, array $order = array(), $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository($this->class);

        return $repo->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function search($query)
    {
        return $this->searchProvider->search($query, Query::HYDRATE_ARRAY);
    }

    /**
     * @inheritdoc
     */
    public function store(Media $media)
    {
        if(!file_exists($media->getPath()))
        {
            throw new MediaFileNotFoundException($media->getPath());
        }

        if(!$media->getUploader() && $this->user instanceof UserInterface)
        {
            $media->setUploader($this->user);
        }

        $this->em->persist($media);
        $this->em->flush($media);

        return $media;
    }

    /**
     * Upload a file, storing it in the temporary
     *
     * @param File  $file
     * @param Media $media
     *
     * @throws Exception\MediaFileDeniedException
     * @return Media
     */
    public function upload(File $file, Media $media = null)
    {
        if(!($media instanceof Media))
        {
            $media = new $this->class();
        }

        if($file instanceof UploadedFile)
        {
            $extension = $file->getClientOriginalExtension();
            $oldName   = $file->getClientOriginalName();
        }
        else
        {
            $extension = $file->getExtension();
            $oldName   = $file->getFilename();
        }

        $fileMime = $file->getMimeType();
        if(array_key_exists($fileMime, $this->accept) && in_array(strtolower($extension), $this->accept[$fileMime]))
        {
            $newFileName = null;

            // if the media name is set, use it over a hashed one
            if($media->getName())
            {
                if($media->getPath() != $file->getPathname()) // if it's already in place, we don't need to move it!
                {
                    $newFileName = $media->getName();
                }
            }
            else
            {
                $newFileName = md5(time() . rand()) . "." . $extension;
            }

            if($newFileName)
            {
                $file = $file->move($this->storePath, $newFileName);
            }
        }
        else
        {
            throw new MediaFileDeniedException($fileMime);
        }

        if($file instanceof File)
        {
            /** @var Media $media */
            if(!$media->getTitle())
            {
                $media->setTitle($oldName);
            }

            $oldPath = pathinfo($oldName);

            if(!$media->getNameOriginal())
            {
                $media->setNameOriginal($oldName);
            }

            if(!$media->getName())
            {
                $media->setName($file->getFilename());
            }

            if(!$media->getAlt())
            {
                $media->setAlt($oldPath['filename']);
            }

            if(!$media->getCredits())
            {
                $media->setCredits($this->user->getUsername());
            }

            $media->setSrc($this->storeDirectory . $file->getFilename());
            $media->setPath($this->storePath . $file->getFilename());

            $this->optimiser->optimise($media);
            $media->setHash(sha1_file($file->getPathname()));


        }

        return $media;
    }

    /**
     * @inheritdoc
     */
    public function update(Media $media)
    {
        // index the media object
        $this->searchProvider->index($media);

        $this->em->persist($media);
        $this->em->flush($media);

        return $media;
    }

    /**
     * @inheritdoc
     */
    public function delete(Media $media)
    {
        $file = $media->getPath();
        if($media->getSrc() && file_exists($file) && is_file($file))
        {
            unlink($file);
        }

        $this->em->remove($media);
        $this->em->flush();
    }

    /**
     * Resize a media object to one or many profiles
     *
     * @param Media $media
     * @param array $profiles
     *
     * @return Media[]
     */
    public function resize(Media $media, array $profiles = array())
    {
        if(!count($profiles))
        {
            $profiles = $this->mediaResizeProfileManager->getProfiles();
        }


        $resizedImages = array();
        foreach($profiles as $profile)
        {
            if(is_string($profile))
            {
                $profile = $this->mediaResizeProfileManager->getProfile($profile);
            }

            if($profile instanceof MediaResizeProfile)
            {
                $resizedImages[] = $this->resizeImage($media, $profile);
            }
        }

        return $resizedImages;
    }


    /**
     * Resize a media object to a set size, returns the persisted media version object
     *
     * @param Media              $media
     * @param MediaResizeProfile $resizeProfile
     *
     * @return MediaVersion
     */
    protected function resizeImage(Media $media, MediaResizeProfile $resizeProfile)
    {
        $imagePath = pathinfo($media->getPath());
        $imageSize = getimagesize($media->getPath());

        // clear old versions
        $repo = $this->em->getRepository($this->getVersionEntityClass());
        $query = $repo->createQueryBuilder('mv')
            ->delete()
            ->where('mv.media = :media')
            ->andWhere('mv.resizeProfile = :profile')
            ->setParameters(array(
                'media' => $media,
                'profile' => $resizeProfile,
            ))
            ->getQuery();
        $query->execute();

        $image = new ImageResize($media->getPath());

        $resizeMethod = ($imageSize[0] >= $imageSize[1])? ImageResize::RESIZE_MAX_WIDTH : ImageResize::RESIZE_MAX_HEIGHT ;
        $image->resizeTo($resizeProfile->getWidth(), $resizeProfile->getHeight(), $resizeMethod);

        $newWidth  = $image->getResizeWidth();
        $newHeight = $image->getResizeHeight();

        $filename         = "{$imagePath['filename']}_{$newWidth}_x_{$newHeight}.{$imagePath['extension']}";
        $resizedImagePath = "{$imagePath['dirname']}" . DIRECTORY_SEPARATOR . "{$filename}";

        $image->saveImage($resizedImagePath);

        if(file_exists($resizedImagePath))
        {
            $class = $this->getVersionEntityClass();

            /** @var MediaVersion $mediaVersion */
            $mediaVersion = new $class();
            $mediaVersion->setMedia($media);
            $mediaVersion->setResizeProfile($resizeProfile);
            $mediaVersion->setPath($resizedImagePath);
            $mediaVersion->setSrc($this->storeDirectory . $filename);

            $this->optimiser->optimise($mediaVersion);

            $this->em->persist($mediaVersion);
            $this->em->flush($mediaVersion);

            return $mediaVersion;
        }

    }

} 
