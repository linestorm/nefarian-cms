<?php

namespace Nefarian\CmsBundle\Plugin\File\Tests\File;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\File\File\LocalStorageFileProvider;
use Nefarian\CmsBundle\Plugin\File\File\FileProviderInterface;
use Nefarian\CmsBundle\Plugin\File\File\Resizer\FileResizer;
use Nefarian\CmsBundle\Plugin\File\File\Resizer\FileResizeProfileManager;
use Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity;
use Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileResizeProfileEntity;
use Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Optimiser\MockOptimiser;
use Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\User\FakeAdminUser;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Unit tests for Local Storeage File Provider
 *
 * Class LocalStorageFileProviderTest
 *
 * @package Nefarian\CmsBundle\Plugin\File\Tests\File
 */
class LocalStorageFileProviderTest extends AbstractFileProviderTest
{
    protected $id = 'local_storeage';
    protected $form = 'linestorm_cms_form_file';
    protected $dir;

    /**
     * @var FakeAdminUser
     */
    protected $user;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var FileResizeProfileManager
     */
    protected $resizeManager;

    protected function setUp()
    {
        $this->dir = __DIR__."/../Fixtures/tmp";
        $this->user = new FakeAdminUser();

        if(!file_exists($this->dir))
            @mkdir($this->dir, 0777, true);

        parent::setUp();
    }

    protected function tearDown()
    {
        if(file_exists($this->dir))
        {
            foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $path) {
                $path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
            }
            rmdir($this->dir);
        }
    }


    /**
     * @param null $repository
     *
     * @return FileProviderInterface
     */
    protected function getProvider($repository = null)
    {
        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';
        $this->em = $this->getMock('\Doctrine\ORM\EntityManager', array('getRepository', 'persist', 'remove', 'flush', 'findAll'), array(), '', false);
        $sc = $this->getMock('\Symfony\Component\Security\Core\SecurityContext', array('getToken'), array(), '', false);

        $token = new UsernamePasswordToken($this->user, 'unittest', 'unittest');
        $sc->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue($token));

        if($repository)
        {
            $this->em->expects($this->once())
                ->method('getRepository')
                ->will($this->returnValue($repository));
        }

        $this->resizeManager = new FileResizeProfileManager($this->em, '');

        $provider = new LocalStorageFileProvider($this->em, $entityClass, $sc, $this->resizeManager, $this->dir, '/');
        $provider->setOptimiser(new MockOptimiser());

        return $provider;
    }


    public function testFind()
    {
        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';

        $repository = $this->getMock('\Doctrine\ORM\EntityRepository', array('find'), array(), '', false);
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->will($this->returnValue(new $entityClass()));

        $provider = $this->getProvider($repository);

        $returnedEntity = $provider->find(1);

        $this->assertInstanceOf($entityClass, $returnedEntity);
    }

    public function testFindBy()
    {
        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';

        $repository = $this->getMock('\Doctrine\ORM\EntityRepository', array('findBy'), array(), '', false);
        $repository->expects($this->once())
            ->method('findBy')
            ->with(array('id' => 1), array(), 1, 0)
            ->will($this->returnValue(array(new $entityClass())));

        $provider = $this->getProvider($repository);

        $returnedEntities = $provider->findBy(array('id' => 1), array(), 1, 0);

        $this->assertTrue(is_array($returnedEntities));
        $this->assertArrayHasKey(0, $returnedEntities);
        $this->assertInstanceOf($entityClass, $returnedEntities[0]);
    }

    public function testStore()
    {
        $img = __DIR__.'/../Fixtures/Images/valid.gif';
        $tmpImg = $this->dir . '/valid.gif';
        copy($img, $tmpImg);

        $file = new FileEntity();
        $file->setPath($tmpImg);

        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';
        $provider = $this->getProvider();
        $this->em->expects($this->once())
            ->method('persist')
            ->with($file)
            ->will($this->returnValue(null));
        $this->em->expects($this->once())
            ->method('flush')
            ->will($this->returnValue(null));


        $returnedFile = $provider->store($file);

        $this->assertInstanceOf($entityClass, $returnedFile);

        $uploader = $returnedFile->getUploader();
        $this->assertInstanceOf('\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\User\FakeAdminUser', $uploader);

    }


    public function testUpload()
    {
        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';
        $provider = $this->getProvider();

        $img = __DIR__.'/../Fixtures/Images/valid.gif';
        $tmpImg = $this->dir . '/valid.gif';
        copy($img, $tmpImg);

        $file = new File($tmpImg);

        $returnedFile = $provider->upload($file);

        $this->assertInstanceOf($entityClass, $returnedFile);

        $title = $returnedFile->getTitle();
        $this->assertEquals($title, 'valid.gif');

        $hash = $returnedFile->getHash();
        $this->assertEquals($hash, sha1_file($img));

        unlink($this->dir.$returnedFile->getSrc());
    }

    public function testDelete()
    {
        $provider = $this->getProvider();
        $this->em->expects($this->once())
            ->method('remove')
            ->will($this->returnValue(null));

        $img = __DIR__.'/../Fixtures/Images/valid.gif';
        $tmpImg = $this->dir . '/valid.gif';
        copy($img, $tmpImg);


        $file = new FileEntity();
        $file->setPath($tmpImg);
        $file->setSrc('/valid.gif');

        $provider->delete($file);

        // check the file was removed
        $this->assertFileNotExists($tmpImg);
    }

    /*public function testResize()
    {
        $entityClass = '\Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity\FileEntity';

        $repository = $this->getMock('\Doctrine\ORM\EntityRepository', array('findAll', 'findBy'), array(), '', false);
        $repository->expects($this->any())
                   ->method('findAll')
                   ->will($this->returnValue(array(new FileResizeProfileEntity())));

        $provider = $this->getProvider($repository);

        $entity = new FileEntity();

        $img = __DIR__.'/../Fixtures/Images/valid.gif';
        $tmpImg = $this->dir.'/resize_valid.gif';
        copy($img, $tmpImg);

        $entity->setPath($tmpImg);
        $entity->setUploader($this->user);

        $resized = $provider->resize($entity);

        $this->assertTrue(is_array($resized));
        $this->assertCount(1, $resized);
        $this->assertArrayHasKey(0, $resized);

        /** @var FileEntity $resizedEntity * /
        $resizedEntity = $resized[0];

        $dir = str_replace('/', '\/', realpath($this->dir));
        $this->assertRegExp('/'.$dir.'\/resize_valid_(\d+)_x_(\d+)\.gif$/', realpath($resizedEntity->getPath()));

    }*/
}
