<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Unit;

use Facile\DoctrineDDM\Configuration\Metadata;
use Facile\DoctrineDDM\MetadataListener;
use Facile\DoctrineDDMTest\Framework\TestCase;

class MetadataListenerTest extends TestCase
{
    /**
     * @var MetadataListener
     */
    protected $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $config = $this->prophesize(Metadata::class);
        $this->listener = new MetadataListener($config->reveal());
    }

    public function testGetSubscribedEvents()
    {
        $this->assertEquals(['loadClassMetadata'], $this->listener->getSubscribedEvents());
    }
}
