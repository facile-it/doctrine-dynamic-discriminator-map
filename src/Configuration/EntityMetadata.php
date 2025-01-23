<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM\Configuration;

/**
 * Class EntityMetadata.
 */
class EntityMetadata
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var array
     */
    protected $discriminatorMap = [];

    /**
     * EntityMetadata constructor.
     */
    public function __construct(string $entityClass, array $discriminatorMap = [])
    {
        $this->entityClass = $entityClass;
        $this->discriminatorMap = $discriminatorMap;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function setEntityClass(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    public function getDiscriminatorMap(): array
    {
        return $this->discriminatorMap;
    }

    public function setDiscriminatorMap(array $discriminatorMap)
    {
        $this->discriminatorMap = $discriminatorMap;
    }
}
