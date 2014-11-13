<?php

namespace Nefarian\CmsBundle\Plugin\File\Command;

use Nefarian\CmsBundle\Plugin\File\Model\File;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command will optimise all file
 *
 * Class IndexCommand
 *
 * @package LineStorm\SearchBundle\Command
 */
class OptimiseFileCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('linestorm:file:optimise')
            ->setDescription('Optimise all file')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $fileManager = $container->get('linestorm.cms.file_manager');
        $optimiser = $container->get('linestorm.cms.file.optimiser');

        /** @var File[] $fileEntities */
        $fileEntities = $fileManager->findBy(array());
        $entityCount = count($fileEntities);

        if($entityCount > 0)
        {
            $output->writeln("Optimising {$entityCount} images");

            $progress = $this->getHelperSet()->get('progress');

            $progress->start($output, $entityCount);
            foreach($fileEntities as $file)
            {
                $optimiser->optimise($file);
                $progress->advance();
            }

            $progress->finish();
        }
        else
        {
            $output->writeln("There were no images found to optimise");
        }

    }
}
