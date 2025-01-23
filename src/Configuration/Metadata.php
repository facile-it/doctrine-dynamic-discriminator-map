<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Configuration;

use Facile\DoctrineDDM\Exception;

/**
 * Class Metadata.
 */
class Metadata
{
    /**
     * @var EntityMetadata[]
     */
    protected $entityMetadatas = [];

    /**
     * @return EntityMetadata[]
     */
    public function getEntityMetadatas(): array
    {
        return $this->entityMetadatas;
    }

    /**
     * @param EntityMetadata[] $entityMetadatas
     *
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
     */
    public function setEntityMetadatas(array $entityMetadatas)
    {
        $this->entityMetadatas = [];

        foreach ($entityMetadatas as $entityMetadata) {
            $this->addEntityMetadata($entityMetadata);
        }
    }

    /**
     * @throws \Facile\DoctrineDDM\Exception\InvalidArgumentException
     */
    public function addEntityMetadata(EntityMetadata $entityMetadata)
    {
        if (array_key_exists($entityMetadata->getEntityClass(), $this->entityMetadatas)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Entity "%s" is already defined',
                $entityMetadata->getEntityClass()
            ));
        }
        $this->entityMetadatas[$entityMetadata->getEntityClass()] = $entityMetadata;
    }

    /**
     * @return EntityMetadata|null
     */
    public function getEntityMetadata(string $entityClass)
    {
        return $this->entityMetadatas[$entityClass] ?? null;
    }
}
