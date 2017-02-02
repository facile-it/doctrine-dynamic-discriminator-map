Doctrine Dynamic Discriminator Map
----------------------------------

[![Latest Stable Version](https://poser.pugx.org/facile-it/doctrine-dynamic-discriminator-map/v/stable)](https://packagist.org/packages/facile-it/doctrine-dynamic-discriminator-map)
[![Total Downloads](https://poser.pugx.org/facile-it/doctrine-dynamic-discriminator-map/downloads)](https://packagist.org/packages/facile-it/doctrine-dynamic-discriminator-map)
[![Latest Unstable Version](https://poser.pugx.org/facile-it/doctrine-dynamic-discriminator-map/v/unstable)](https://packagist.org/packages/facile-it/doctrine-dynamic-discriminator-map)
[![License](https://poser.pugx.org/facile-it/doctrine-dynamic-discriminator-map/license)](https://packagist.org/packages/facile-it/doctrine-dynamic-discriminator-map)

Adds ability do declare entity discriminator map using a configuration.

Installation
============

```
$ composer require facile-it/doctrine-dynamic-discriminator-map
```

### Register the listener on Doctrine Event Manager

Example:

```php
<?php

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Facile\DoctrineDDM\Factory\MetadataConfigFactory;
use Facile\DoctrineDDM\MetadataListener;
use My\Namespace\Entity;

$metadataConfigFactory = new MetadataConfigFactory();
// discriminator map configuration
$metadataConfig = $metadataConfigFactory->createMetadata([
    Entity\Person::class => [ // parent class
        'discriminator_map' => [
            'teacher' => Entity\Teacher::class, // child class
            'student' => Entity\Student::class, // child class
        ],
    ],
]);

$metadataListener = new MetadataListener($metadataConfig);

$eventManager = new EventManager();
$eventManager->addEventSubscriber($metadataListener);

$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . '/src'],
    true,
    null,
    null,
    false
);
$connection = [
    'driver' => 'pdo_sqlite',
    'memory' => true,
];

$entityManager = EntityManager::create($connection, $config, $eventManager);

```

### Entities

Create the parent entity:

```php 
<?php

namespace My\Namespace\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"person" = "Person"})
 */
class Person
{
    // ...
}
```

Then you can declare the children entities:

```php
<?php

namespace My\Namespace\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student extends Person
{
    // ...
}

/**
 * @ORM\Entity
 */
class Teacher extends Person
{
    // ...
}
```

That's it!


Frameworks Integration
======================

### Invokable factories

`Facile\DoctrineDDM\Factory\MetadataConfigFactory` and `Facile\DoctrineDDM\Factory\MetadataListenerFactory`
have an `__invoke()` method that can be used with `Interop\Container\ContainerInterface`.

`Facile\DoctrineDDM\Factory\MetadataConfigFactory` will check for a `config` key where 
expects an array configuration.  
Then it will check for `Facile\DoctrineDDM\Factory\MetadataConfigFactory::CONFIG_KEY` key 
where it expects the discriminator map configuration and returns a
`Facile\DoctrineDDM\Configuration\Metadata` instance.

`Facile\DoctrineDDM\Factory\MetadataListenerFactory` will check for a service named 
`Facile\DoctrineDDM\Configuration\Metadata` (the configuration class) then will return 
a configured `Facile\DoctrineDDM\MetadataListener` instance.


### Zend Framework and Zend Expressive

With [DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule):

```php

use Facile\DoctrineDDM\MetadataListener;
use Facile\DoctrineDDM\Factory\MetadataConfigFactory;
use Facile\DoctrineDDM\Factory\MetadataListenerFactory;
use Facile\DoctrineDDM\Configuration\Metadata;
use My\Namespace\Entity;

return [
    'service_manager' => [ // or "dependencies" for zend-expressive
        'factories' => [
            // register the configuration factory
            Metadata::class => MetadataConfigFactory::class,
            // register the metadata listener factory
            MetadataListener::class => MetadataListenerFactory::class,
        ],
    ],
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    // register MetadataListener
                    MetadataListener::class,
                ],
            ],
        ],
    ],
    // declare discriminator map configuration used by MetadataConfigFactory
    MetadataConfigFactory::CONFIG_KEY => [
        Entity\Person::class => [ // parent class
            'discriminator_map' => [
                'teacher' => Entity\Teacher::class, // child class
                'student' => Entity\Student::class, // child class
            ],
        ],
    ],
];
```