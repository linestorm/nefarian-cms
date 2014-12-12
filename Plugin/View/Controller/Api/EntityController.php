<?php

namespace Nefarian\CmsBundle\Plugin\View\Controller\Api;

use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ViewController
 *
 * @package Nefarian\CmsBundle\Plugin\View\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class EntityController extends Controller
{

    public function getEntitiesAction()
    {
        $viewManager = $this->get('nefarian.plugin.view.view_manager');
        $views       = $viewManager->getViews();

        $entities = array();
        foreach ($views as $view) {
            $metaData = $viewManager->getMetaDataForView($view);
            if (!$metaData->isMappedSuperclass) {
                $entities[] = array(
                    'value' => $view->getName(),
                    'name' => $metaData->getTableName(),
                );
            }
        }

        $view = new View($entities);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getEntityFieldsAction(Request $request)
    {
        $viewName = $request->query->get('entity');

        if (!$viewName) {
            throw new BadRequestHttpException('Entity not provided');
        }

        $viewManager = $this->get('nefarian.plugin.view.view_manager');
        $view        = $viewManager->getView($viewName);

        $viewForm = $viewManager->buildView($view);

        $fields       = array();
        $associations = array();

        foreach ($viewForm->getFields() as $name => $type) {
            $fields[] = array(
                'name' => $name,
                'parent' => $view->getName()
            );
        }

        foreach ($viewForm->getAssociations() as $name => $type) {
            $associations[] = array(
                'name' => $name,
                'parent' => $view->getName()
            );
        }

        $view = new View(array(
            'fields' => $fields,
            'associations' => $associations,
        ));

        return $this->get('fos_rest.view_handler')->handle($view);
    }

} 
