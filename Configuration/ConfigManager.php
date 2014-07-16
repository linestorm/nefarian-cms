<?php

namespace Nefarian\CmsBundle\Configuration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class ConfigManager
 *
 * @package Nefarian\CmsBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigManager
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repository;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('NefarianCmsBundle:Config');
    }

    public function get($name)
    {
        return $this->repository->find($name);
    }

} 
