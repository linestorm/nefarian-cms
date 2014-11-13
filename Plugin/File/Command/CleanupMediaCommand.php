<?php

namespace Nefarian\CmsBundle\Plugin\File\Command;

use Nefarian\CmsBundle\Plugin\File\File\LocalStorageFileProvider;
use Nefarian\CmsBundle\Plugin\File\Model\File;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command will clean up all unused images
 *
 * Class CleanupFileCommand
 *
 * @package LineStorm\SearchBundle\Command
 */
class CleanupFileCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('linestorm:file:purge-orphans')
            ->addOption('force', null, null, 'Force the purge')
            ->setDescription('Purges all orphaned images')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $fileManager = $container->get('linestorm.cms.file_manager');

        $provider = $fileManager->getDefaultProviderInstance();

        if(!$provider instanceof LocalStorageFileProvider)
        {
            $output->writeln('You can only purge file from a local storage provider');
            return false;
        }

        /** @var File[] $fileEntities */
        $fileEntities = $fileManager->findBy(array());

        $output->writeln("Building Path Index");
        $paths = array();
        foreach($fileEntities as $file)
        {
            $paths[] = $file->getPath();

            foreach($file->getVersions() as $version)
            {
                $paths[] = $version->getPath();
            }
        }

        $output->writeln("Calculating Purgable Images");

        $basePath = $fileManager->getDefaultProviderInstance()->getStorePath();
        $files = glob($basePath.'*.{png,gif,jpg,jpeg}', GLOB_BRACE);

        $purgable = array_diff($files, $paths);
        $purgeCount = count($purgable);
        $output->writeln("Found {$purgeCount} images that can be purged");
        if(!$input->getOption('force'))
        {
            $output->writeln('You must use --force to execute the purge');
        }
        elseif($purgeCount > 0)
        {
            $output->writeln("Purging images Images");

            $progress = $this->getHelperSet()->get('progress');

            $progress->start($output, $purgeCount);
            foreach($purgable as $pfile)
            {
                unlink($pfile);
                $progress->advance();
            }

            $progress->finish();
        }
        else
        {
            $output->writeln("No images were purged, as none were found to be invalid");
        }

    }
}
