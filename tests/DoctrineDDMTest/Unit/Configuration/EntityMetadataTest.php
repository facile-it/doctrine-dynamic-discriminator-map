<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Unit\Configuration;

use Facile\DoctrineDDM\Configuration\EntityMetadata;
use Facile\DoctrineDDMTest\Framework\TestCase;

class EntityMetadataTest extends TestCase
{
    public function testConstructor()
    {
        $entityMetadata = new EntityMetadata('foo', ['foo' => 'bar']);

        $this->assertEquals('foo', $entityMetadata->getEntityClass());
        $this->assertEquals(['foo' => 'bar'], $entityMetadata->getDiscriminatorMap());
    }

    public function testConstructorWithOneArgument()
    {
        $entityMetadata = new EntityMetadata('foo');

        $this->assertEquals('foo', $entityMetadata->getEntityClass());
        $this->assertEquals([], $entityMetadata->getDiscriminatorMap());
    }

    public function testSetEntityClass()
    {
        $entityMetadata = new EntityMetadata('foo');

        $entityMetadata->setEntityClass('bar');

        $this->assertEquals('bar', $entityMetadata->getEntityClass());
    }

    public function testSetDiscriminatorMap()
    {
        $entityMetadata = new EntityMetadata('foo');

        $entityMetadata->setDiscriminatorMap(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $entityMetadata->getDiscriminatorMap());
    }
}
