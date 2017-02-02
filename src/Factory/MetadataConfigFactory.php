<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Factory;

use Facile\DoctrineDDM\Configuration;
use Interop\Container\ContainerInterface;

class MetadataConfigFactory
{
    /**
     * @var string
     */
    const CONFIG_KEY = 'doctrine_dynamic_discriminator_map';

    /**
     * @param ContainerInterface $container
     *
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
     *
     * @return Configuration\Metadata
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        return $this->createMetadata($config[self::CONFIG_KEY] ?? []);
    }

    /**
     * @param array $configuration
     *
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
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
