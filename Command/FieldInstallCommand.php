<?php

namespace Nefarian\CmsBundle\Command;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @TODO: Remove uninstalled fields
 * @TODO: Check for child rows and abort delete
 *
 * Class FieldInstallCommand
 *
 * @package Nefarian\CmsBundle\Command
 */
class FieldInstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('nefarian:content:fields:install')
            ->setDescription('Install all registered content fields')
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force install'
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $fieldManager = $container->get('nefarian_core.content_field_manager');
        $em           = $container->get('doctrine')->getManager();
        $fieldRepo    = $em->getRepository('PluginContentManagement:Field');

        $force = $input->getOption('force');
        if($force)
        {
            foreach($fieldManager->getFields() as $field)
            {
                $output->writeln('Installing ' . $field->getName());
                $fieldEntity = $fieldRepo->findOneBy(array('name' => $field->getName()));
                if(!$fieldEntity instanceof Field)
                {
                    $fieldEntity = new Field();
                }
                $fieldEntity->setName($field->getName());
                $fieldEntity->setLabel($field->getLabel());
                $fieldEntity->setDescription($field->getDescription());

                $em->persist($fieldEntity);
            }

            $em->flush();
        }
        else
        {
            $output->writeln('Use --force to update the database');
        }
    }
} 
