<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Factory;

use Facile\DoctrineDDM\Configuration;
use Facile\DoctrineDDM\Exception\InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

class MetadataConfigFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws ContainerExceptionInterface If any other error occurs.
     * @throws InvalidArgumentException
     *
     * @return Configuration\Metadata
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return $this->createMetadata($config[self::class] ?? []);
    }

    /**
     * @param array $configuration
     *
     * @throws InvalidArgumentException
     *
     * @return Configuration\Metadata
     */
    public function createMetadata(array $configuration): Configuration\Metadata
    {
        $entities = [];
        foreach ($configuration as $entityClass => $config) {
            $entities[] = $this->createEntityMetadata($entityClass, $config);
        }

        $metadata = new Configuration\Metadata();
        $metadata->setEntityMetadatas($entities);

        return $metadata;
    }

    /**
     * @param string $entity
     * @param array  $configuration
     *
     * @return Configuration\EntityMetadata
     */
    protected function createEntityMetadata(string $entity, array $configuration): Configuration\EntityMetadata
    {
        return new Configuration\EntityMetadata($entity, $configuration['discriminator_map'] ?? []);
    }
}
