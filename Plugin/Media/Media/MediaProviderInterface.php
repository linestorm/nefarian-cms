<?php

namespace Nefarian\CmsBundle\Plugin\Media\Media;

use Nefarian\CmsBundle\Plugin\Media\Model\Media;
use LineStorm\SearchBundle\Search\SearchProviderInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Interface that all media providers must implement
 *
 * Interface MediaProviderInterface
 * @package Nefarian\CmsBundle\Plugin\Media\Media
 */
interface MediaProviderInterface
{

    /**
     * Get the storage provider's id
     *
     * @return string
     */
    public function getId();

    /**
     * Get a edit/new Form for the media
     *
     * @return string
     */
    public function getForm();

    /**
     * Get an image from storage
     *
     * @param $id
     *
     * @return Media
     */
    public function find($id);

    /**
     * @param array   $criteria
     * @param array   $order
     * @param integer $limit
     * @param integer $offset
     *
     * @return Media|null
     */
    public function findBy(array $criteria, array $order = array(), $limit = null, $offset = null);

    /**
     * Find an image by the hash. This can stop duplicate images being uploaded.
     *
     * @param string $hash
     *
     * @return Media|null
     */
    public function findByHash($hash);

    /**
     * Store an image in the storeage

     * @param Media $media
     *
     * @return Media
     */
    public function store(Media $media);

    /**
     * Upload a file, return a media object
     * NOTE THAT THE RETURNED MEDIA OBJECT IS NOT PERSISTED
     *
     * @param File  $file
     * @param Media $media
     *
     * @return mixed
     */
    public function upload(File $file, Media $media = null);

    /**
     * Update an image in storage
     *
     * @param Media $media
     *
     * @return Media
     */
    public function update(Media $media);

    /**
     * Delete an image in storage
     *
     * @param Media $media
     *
     * @return void
     */
    public function delete(Media $media);

    /**
     * Set the search provider
     *
     * @param SearchProviderInterface $searchProvider
     *
     * @return void
     */
    public function setSearchProvider(SearchProviderInterface $searchProvider);

    /**
     * Search for media by text
     *
     * @param $query
     *
     * @return mixed
     */
    public function search($query);

    /**
     * Resize a media object
     *
     * @param Media $media
     * @param array $profiles
     *
     * @return mixed
     */
    public function resize(Media $media, array $profiles = array());
} 
