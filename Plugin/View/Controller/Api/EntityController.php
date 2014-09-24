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
        $em          = $this->getDoctrine()->getManager();
        $metaFactory = $em->getMetadataFactory();

        /** @var \Doctrine\ORM\Mapping\ClassMetadata[] $metaSchemas */
        $metaSchemas = $metaFactory->getAllMetadata();

        $entities = array();
        foreach($metaSchemas as $metaSchema)
        {
            if(!$metaSchema->isMappedSuperclass)
            {
                $entities[] = array(
                    'value' => sha1($metaSchema->getName()),
                    'name'  => $metaSchema->getTableName(),
                );
            }
        }

        $view = new View($entities);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getEntityFieldsAction(Request $request)
    {
        $entityHash = $request->query->get('entity');

        if(!$entityHash)
        {
            throw new BadRequestHttpException('Entity not provided');
        }

        $em          = $this->getDoctrine()->getManager();
        $metaFactory = $em->getMetadataFactory();

        /** @var \Doctrine\ORM\Mapping\ClassMetadata[] $metaSchemas */
        $metaSchemas = $metaFactory->getAllMetadata();

        $associations = array();
        $fields       = array();
        foreach($metaSchemas as $metaSchema)
        {
            $hash = sha1($metaSchema->getName());
            if($hash == $entityHash)
            {
                $table = $metaSchema->getTableName();
                foreach($metaSchema->getFieldNames() as $fieldName)
                {
                    $fields[] = $table . '.' . $fieldName;
                }

                foreach($metaSchema->associationMappings as $associationSchema)
                {
                    $associations[] = array(
                        'name' => $table . '.' . $associationSchema['fieldName'],
                        'hash' => sha1($associationSchema['targetEntity']),
                    );
                }

                // no point in continuing
                break;
            }
        }

        $view = new View(array(
            'fields'       => $fields,
            'associations' => $associations,
        ));

        return $this->get('fos_rest.view_handler')->handle($view);
    }

} 
