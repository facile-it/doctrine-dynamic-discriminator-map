<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Unit\Configuration;

use Facile\DoctrineDDM\Configuration\EntityMetadata;
use Facile\DoctrineDDM\Configuration\Metadata;
use Facile\DoctrineDDM\Exception\InvalidArgumentException;
use Facile\DoctrineDDMTest\Framework\TestCase;

class MetadataTest extends TestCase
{
    public function testConstructor()
    {
        $metadata = new Metadata();

        $this->assertEquals([], $metadata->getEntityMetadatas());
        $this->assertNull($metadata->getEntityMetadata('foo'));
    }

    public function testSetEntities()
    {
        $metadata = new Metadata();

        $fooEntityMetadata = $this->prophet->prophesize(EntityMetadata::class);
        $fooEntityMetadata->getEntityClass()->willReturn('foo');

        $barEntityMetadata = $this->prophet->prophesize(EntityMetadata::class);
        $barEntityMetadata->getEntityClass()->willReturn('bar');

        $metadata->setEntityMetadatas([
            $fooEntityMetadata->reveal(),
            $barEntityMetadata->reveal(),
        ]);

        $expected = [
            'foo' => $fooEntityMetadata->reveal(),
            'bar' => $barEntityMetadata->reveal(),
        ];

        $this->assertEquals($expected, $metadata->getEntityMetadatas());
    }

    public function testAddEntityMetadata()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Entity "foo" is already defined');

        $metadata = new Metadata();

        $fooEntityMetadata1 = $this->prophet->prophesize(EntityMetadata::class);
        $fooEntityMetadata1->getEntityClass()->willReturn('foo');

        $fooEntityMetadata2 = $this->prophet->prophesize(EntityMetadata::class);
        $fooEntityMetadata2->getEntityClass()->willReturn('foo');

        $metadata->addEntityMetadata($fooEntityMetadata1->reveal());
        $metadata->addEntityMetadata($fooEntityMetadata2->reveal());
    }

    public function testGetEntityMetadata()
    {
        $metadata = new Metadata();

        $fooEntityMetadata = $this->prophet->prophesize(EntityMetadata::class);
        $fooEntityMetadata->getEntityClass()->willReturn('foo');

        $metadata->setEntityMetadatas([
            $fooEntityMetadata->reveal(),
        ]);

        $this->assertSame($fooEntityMetadata->reveal(), $metadata->getEntityMetadata('foo'));
    }

    public function testGetEntityMetadataWithInvalidClass()
    {
        $metadata = new Metadata();

        $this->assertNull($metadata->getEntityMetadata('foo'));
    }
}
