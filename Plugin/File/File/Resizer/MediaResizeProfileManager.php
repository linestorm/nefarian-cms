<?php

namespace Nefarian\CmsBundle\Plugin\File\File\Resizer;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\File\Model\FileResizeProfile;

/**
 * Class FileResizeProfileManager
 *
 * @package Nefarian\CmsBundle\Plugin\File\File
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileResizeProfileManager
{
    /**
     * @var FileResizeProfile[]
     */
    private $fileResizeProfiles = array();

    /**
     * @var string
     */
    private $fileResizeClass;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param $em
     * @param $fileResizeClass
     */
    function __construct(EntityManager $em, $fileResizeClass)
    {
        $this->em               = $em;
        $this->fileResizeClass = $fileResizeClass;
    }

    /**
     * Get a profile by name
     *
     * @param $name
     *
     * @return FileResizeProfile
     */
    public function getProfile($name)
    {
        if(array_key_exists($name, $this->fileResizeProfiles))
        {
            return $this->fileResizeProfiles[$name];
        }

        $repo = $this->em->getRepository($this->fileResizeClass);
        $profile = $repo->findOneBy(array( 'name' => $name ));

        if($profile instanceof FileResizeProfile)
        {
            $this->fileResizeProfiles[$profile->getName()] = $profile;

            return $profile;
        }

        return null;
    }

    /**
     * Get all profiles
     *
     * @return FileResizeProfile[]
     */
    public function getProfiles()
    {
        $repo = $this->em->getRepository($this->fileResizeClass);
        $profiles = $repo->findAll();

        foreach($profiles as $profile)
        {
            $this->fileResizeProfiles[$profile->getName()] = $profile;
        }

        return $this->fileResizeProfiles;
    }

}
