<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Unit\Factory;

use Facile\DoctrineDDM\Configuration\Metadata;
use Facile\DoctrineDDM\Factory\MetadataListenerFactory;
use Facile\DoctrineDDM\MetadataListener;
use Facile\DoctrineDDMTest\Framework\TestCase;
use Psr\Container\ContainerInterface;

class MetadataListenerFactoryTest extends TestCase
{
    public function testInvoke()
    {
        $metadataConfig = $this->prophesize(Metadata::class);
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(Metadata::class)->willReturn($metadataConfig->reveal());

        $factory = new MetadataListenerFactory();

        $instance = $factory($container->reveal());

        $this->assertInstanceOf(MetadataListener::class, $instance);
    }
}
