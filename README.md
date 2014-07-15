Nefarian CMS Core
=================

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
