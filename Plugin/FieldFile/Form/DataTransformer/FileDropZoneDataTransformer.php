<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form\DataTransformer;

use Nefarian\CmsBundle\Plugin\FieldFile\Entity\FieldFile;
use Symfony\Component\Form\DataTransformerInterface;

class FileDropZoneDataTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     *
     * Apply the file deltas
     */
    public function reverseTransform($value)
    {
        /** @var FieldFile $value */
        foreach ($value as $i => $item) {
            $item->setDelta($i);
        }

        return $value;
    }

} 
