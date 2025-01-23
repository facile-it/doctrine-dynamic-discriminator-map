<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Factory;

use Facile\DoctrineDDM\Configuration;
use Psr\Container\ContainerInterface;

class MetadataConfigFactory
{
    /**
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
     *
     * @return Configuration\Metadata
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return $this->createMetadata($config[self::class] ?? []);
    }

    /**
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
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

    protected function createEntityMetadata(string $entity, array $configuration): Configuration\EntityMetadata
    {
        return new Configuration\EntityMetadata($entity, $configuration['discriminator_map'] ?? []);
    }
}
