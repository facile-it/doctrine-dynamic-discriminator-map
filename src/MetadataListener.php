<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Facile\DoctrineDDM\Configuration\Metadata as Configuration;

/**
 * Class MetadataListener.
 */
class MetadataListener implements EventSubscriber
{
    /**
     * @var Configuration
     */
    protected $metadataConfig;

    /**
     * MetadataListener constructor.
     *
     * @param Configuration $metadataConfig
     */
    public function __construct(Configuration $metadataConfig)
    {
        $this->metadataConfig = $metadataConfig;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['loadClassMetadata'];
    }

    /**
     * @param LoadClassMetadataEventArgs $event
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $event->getClassMetadata();

        $entityMetadata = $this->metadataConfig->getEntityMetadata($metadata->getName());

        if (! $entityMetadata) {
            return;
        }

        $class = $metadata->getReflectionClass();
        if ($class === null) {
            $class = new \ReflectionClass($metadata->getName());
        }

        $reader = new AnnotationReader();

        $discriminatorMap = [];
        $discriminatorMapAnnotation = $reader->getClassAnnotation($class, DiscriminatorMap::class);

        if (null !== $discriminatorMapAnnotation) {
            $discriminatorMap = $discriminatorMapAnnotation->value;
        }

        $discriminatorMap = array_merge($discriminatorMap, $entityMetadata->getDiscriminatorMap());
        $metadata->setDiscriminatorMap($discriminatorMap);
    }
}
