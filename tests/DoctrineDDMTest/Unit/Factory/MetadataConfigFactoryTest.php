<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Unit\Factory;

use Facile\DoctrineDDM\Configuration\EntityMetadata;
use Facile\DoctrineDDM\Configuration\Metadata;
use Facile\DoctrineDDM\Factory\MetadataConfigFactory;
use Facile\DoctrineDDMTest\Framework\TestCase;
use Interop\Container\ContainerInterface;

class MetadataConfigFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $config = [];
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->willReturn($config);

        $factory = new MetadataConfigFactory();

        $instance = $factory($container->reveal());

        $this->assertInstanceOf(Metadata::class, $instance);
        $this->assertCount(0, $instance->getEntityMetadatas());
    }

    public function testInvokeWithConfig()
    {
        $config = [
            'doctrine_dynamic_discriminator_map' => [
                'class1' => [
                    'discriminator_map' => [
                        'foo' => 'bar',
                    ],
                ],
            ],
        ];
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->willReturn($config);

        $factory = new MetadataConfigFactory();

        /** @var Metadata $instance */
        $instance = $factory($container->reveal());

        $this->assertInstanceOf(Metadata::class, $instance);
        $this->assertCount(1, $instance->getEntityMetadatas());
    }

    public function testCreateMetadata()
    {
        $config = [
            'class1' => [
                'discriminator_map' => [
                    'foo1' => 'bar1',
                    'foo2' => 'bar2',
                ],
            ],
            'class2' => [
                'discriminator_map' => [
                    'foo3' => 'bar3',
                ],
            ],
        ];

        $factory = new MetadataConfigFactory();

        /** @var Metadata $instance */
        $instance = $factory->createMetadata($config);

        $this->assertInstanceOf(Metadata::class, $instance);
        $this->assertCount(2, $instance->getEntityMetadatas());

        $entityMetadata1 = $instance->getEntityMetadata('class1');
        $entityMetadata2 = $instance->getEntityMetadata('class2');

        $this->assertInstanceOf(EntityMetadata::class, $entityMetadata1);
        $this->assertInstanceOf(EntityMetadata::class, $entityMetadata2);

        $this->assertEquals('class1', $entityMetadata1->getEntityClass());
        $this->assertEquals('class2', $entityMetadata2->getEntityClass());

        $this->assertEquals(
            [
                'foo1' => 'bar1',
                'foo2' => 'bar2',
            ],
            $entityMetadata1->getDiscriminatorMap()
        );
        $this->assertEquals(
            [
                'foo3' => 'bar3',
            ],
            $entityMetadata2->getDiscriminatorMap()
        );
    }
}
