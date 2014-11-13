<?php

namespace Nefarian\CmsBundle\Plugin\File\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command will re-index all databases
 *
 * Class IndexCommand
 *
 * @package LineStorm\SearchBundle\Command
 */
class ResizeFileCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('linestorm:file:resize')
            ->setDescription('Resize all missing file versions')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $fileManager = $container->get('linestorm.cms.file_manager');

        $fileEntities = $fileManager->findBy(array());

        foreach($fileEntities as $file)
        {
            $output->writeln("Resizing {$file->getTitle()}");

            $fileManager->resize($file);
        }

        $output->writeln("Finished");

    }
}
