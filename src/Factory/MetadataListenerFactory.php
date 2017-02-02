<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Factory;

use Facile\DoctrineDDM\Configuration\Metadata;
use Facile\DoctrineDDM\MetadataListener;
use Interop\Container\ContainerInterface;

/**
 * Class MetadataListenerFactory.
 */
class MetadataListenerFactory
{
    /**
     * Create service.
     *
     * @param ContainerInterface $container
     *
     * @throws \Interop\Container\Exception\ContainerException
     *
     * @return MetadataListener
     */
    public function __invoke(ContainerInterface $container): MetadataListener
    {
        /** @var Metadata $config */
        $config = $container->get(Metadata::class);

        return new MetadataListener($config);
    }
}
