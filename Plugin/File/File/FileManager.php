<?php

namespace Nefarian\CmsBundle\Plugin\File\File;

use Nefarian\CmsBundle\Plugin\File\Model\File;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

/**
 * Class FileManager
 *
 * @package Nefarian\CmsBundle\Plugin\File\File
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileManager implements \Countable
{
    /**
     * @var FileProviderInterface[]
     */
    private $fileProviders = array();

    private $defaultProvider = null;

    /**
     * Get the total number of file providers
     *
     * @return int
     */
    public function count()
    {
        return count($this->fileProviders);
    }

    /**
     * Get all the file providers
     *
     * @return FileProviderInterface[]
     */
    public function getFileProviders()
    {
        return $this->fileProviders;
    }

    /**
     * Add a file provider to the stack
     *
     * @param FileProviderInterface $fileProvider
     */
    public function addFileProvider(FileProviderInterface $fileProvider)
    {
        $this->fileProviders[$fileProvider->getId()] = $fileProvider;
    }

    /**
     * Set the default file provider by Id
     *
     * @param string $provider
     */
    public function setDefaultProvider($provider)
    {
        $this->defaultProvider = $provider;
    }

    /**
     * @return FileProviderInterface
     */
    public function getDefaultProviderInstance()
    {
        return $this->fileProviders[$this->defaultProvider];
    }

    /**
     * Search the file providers for
     *
     * @param string $id       Image identifier
     * @param string $provider Provider Identifier
     *
     * @return null
     */
    public function find($id, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->find($id);
        }
        else
        {
            $provider = $this->getDefaultProviderInstance();

            return $provider->find($id);
        }
    }

    /**
     * Search the file providers for
     *
     * @param array  $terms
     * @param string $provider Provider Identifier
     *
     * @internal param string $id Image identifier
     * @return null
     */
    public function findBy(array $terms, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->findBy($terms);
        }
        else
        {
            $provider = $this->getDefaultProviderInstance();

            return $provider->findBy($terms);
        }
    }

    /**
     * Search for file by text
     *
     * @param string $query
     * @param null   $provider
     *
     * @return mixed
     */
    public function search($query, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->searchBy($query);
        }
        else
        {
            $provider = $this->getDefaultProviderInstance();

            return $provider->search($query);
        }
    }

    /**
     * Upload a file file
     *
     * @param SymfonyFile   $symfonyFile
     * @param File  $file
     * @param string $provider
     *
     * @return mixed
     */
    public function upload(SymfonyFile $symfonyFile, File $file = null, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->upload($symfonyFile, $file);
        }
        else
        {
            return $this->fileProviders[$this->defaultProvider]->upload($symfonyFile, $file);
        }
    }


    /**
     * Store the file into the bank
     *
     * @param File  $file
     * @param string $provider
     *
     * @return File
     */
    public function store(File $file, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->store($file);
        }
        else
        {
            return $this->fileProviders[$this->defaultProvider]->store($file);
        }
    }

    /**
     * Update a file model
     *
     * @param File $file
     * @param null  $provider
     *
     * @return File
     */
    public function update(File $file, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->update($file);
        }
        else
        {
            return $this->fileProviders[$this->defaultProvider]->update($file);
        }
    }


    /**
     * Delete a file model
     *
     * @param File $file
     * @param null  $provider
     *
     * @return File
     */
    public function delete(File $file, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            $this->fileProviders[$provider]->delete($file);
        }
        else
        {
            $this->fileProviders[$this->defaultProvider]->delete($file);
        }
    }

    /**
     * Resize file
     *
     * @param File $file
     * @param null  $provider
     *
     * @return File[]
     */
    public function resize(File $file, $provider = null)
    {
        if($provider && array_key_exists($provider, $this->fileProviders))
        {
            return $this->fileProviders[$provider]->resize($file);
        }
        else
        {
            return $this->fileProviders[$this->defaultProvider]->resize($file);
        }
    }
}
