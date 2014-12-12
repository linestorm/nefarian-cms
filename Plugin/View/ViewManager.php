<?php

namespace Nefarian\CmsBundle\Plugin\View;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Nefarian\CmsBundle\Plugin\View\View\ViewFormBuilder;
use Nefarian\CmsBundle\Plugin\View\View\ViewInterface;

class ViewManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ViewFormBuilder
     */
    protected $viewFormBuilder;

    /**
     * @var ViewInterface[]
     */
    protected $views = array();

    function __construct(EntityManager $em, ViewFormBuilder $viewFormBuilder)
    {
        $this->em              = $em;
        $this->viewFormBuilder = $viewFormBuilder;
    }

    /**
     * @param ViewInterface $view
     *
     * @return ClassMetadata
     */
    public function getMetaDataForView(ViewInterface $view)
    {
        return $this->em->getClassMetadata($view->getEntity());
    }

    /**
     * @param ViewInterface $view
     */
    public function addView(ViewInterface $view)
    {
        $this->views[$view->getName()] = $view;
    }

    /**
     * @return View\ViewInterface[]
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param string $name
     *
     * @return ViewInterface
     */
    public function getView($name)
    {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }
    }

    /**
     * @param ViewInterface $view
     *
     * @return View\ViewForm
     */
    public function buildView(ViewInterface $view)
    {
        return $this->viewFormBuilder->build($view);
    }

} 
