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
     *
     * @param string $entityClass
     * @param array  $discriminatorMap
     */
    public function __construct(string $entityClass, array $discriminatorMap = [])
    {
        $this->entityClass = $entityClass;
        $this->discriminatorMap = $discriminatorMap;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @return array
     */
    public function getDiscriminatorMap(): array
    {
        return $this->discriminatorMap;
    }

    /**
     * @param array $discriminatorMap
     */
    public function setDiscriminatorMap(array $discriminatorMap)
    {
        $this->discriminatorMap = $discriminatorMap;
    }
}
