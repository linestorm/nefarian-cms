Nefarian CMS Core
=================

Configuration
-------------

1. Enable the bundles in the AppKernel.php:
```php
    $bundles = array(
        // ...

        new Nefarian\CmsBundle\NefarianCmsBundle(),
        new Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle(),
        new FOS\UserBundle\FOSUserBundle(),
        new FOS\RestBundle\FOSRestBundle(),
        new JMS\SerializerBundle\JMSSerializerBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
```

config.yml
----------

Add the loader:

```yml
    framework:
        ...
        templating:
            loaders:
              - templating.loader.filesystem
              - templating.loader.theme_loader
            ...
```

@todo: documentation
