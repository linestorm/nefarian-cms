<?php

namespace Nefarian\CmsBundle\Command;

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
class BuildConfigurationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('nefarian:config:build')
            ->setDescription('Build the configurations')
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Force build'
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $configManager = $container->get('nefarian_core.config_manager');

        $force = $input->getOption('force');
        if ($force) {
            $configManager->rebuild();
        } else {
            $output->writeln('Use --force to rebuild the configuration');
        }
    }
} 
