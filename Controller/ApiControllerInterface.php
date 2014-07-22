<?php

namespace Nefarian\CmsBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;

interface ApiControllerInterface
{
    /** @var int */
    const METHOD_GET = 0;
    /** @var int */
    const METHOD_NEW = 1;
    /** @var int */
    const METHOD_EDIT = 2;
    /** @var int */
    const METHOD_POST = 3;
    /** @var int */
    const METHOD_PUT = 4;
    /** @var int */
    const METHOD_DELETE = 5;

    /** @var int */
    const TYPE_PRE = 0;
    /** @var int */
    const TYPE_POST = 1;

    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm();

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass();

    /**
     * Configure the query builder
     *
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    function setupQueryBuilder(QueryBuilder $qb);


    /**
     * Get the template for the form
     *
     * @param $method
     *
     * @return string
     */
    function getFormTemplate($method);

    /**
     * Lookup the method and build a URL
     *
     * @param int   $method
     * @param mixed $entity
     *
     * @return mixed
     */
    function getUrl($method, $entity = null);
} 
