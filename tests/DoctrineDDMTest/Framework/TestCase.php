<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Framework;

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use Facile\DoctrineDDM\Factory\MetadataConfigFactory;
use Facile\DoctrineDDM\MetadataListener;
use Prophecy\PhpUnit\ProphecyTrait;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var bool
     */
    protected $hasDb = false;

    /**
     * @var array
     */
    protected $arrayConfig;

    public function getArrayConfig(): array
    {
        if (! $this->arrayConfig) {
            $this->arrayConfig = include __DIR__ . './../../config/testing.config.php';
        }

        return $this->arrayConfig;
    }

    public function getEntityManager(): EntityManager
    {
        if (! $this->entityManager) {
            $metadataConfigFactory = new MetadataConfigFactory();
            $eventManager = new EventManager();
            $eventManager->addEventSubscriber(
                new MetadataListener(
                    $metadataConfigFactory->createMetadata($this->getArrayConfig()[MetadataConfigFactory::class])
                )
            );
            $config = Setup::createAnnotationMetadataConfiguration(
                [__DIR__ . '/../Assets'],
                true,
                null,
                null,
                false
            );
            $connection = [
                'driver' => 'pdo_sqlite',
                'memory' => true,
            ];

            $this->entityManager = EntityManager::create($connection, $config, $eventManager);
        }

        return $this->entityManager;
    }

    /**
     * Creates a database if not done already.
     */
    public function createDb()
    {
        if ($this->hasDb) {
            return;
        }

        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        $tool->updateSchema($em->getMetadataFactory()->getAllMetadata());
        $this->hasDb = true;
    }

    /**
     * Drops existing database.
     */
    public function dropDb()
    {
        $em = $this->getEntityManager();
        $tool = new SchemaTool($em);
        $tool->dropSchema($em->getMetadataFactory()->getAllMetadata());
        $em->clear();

        $this->hasDb = false;
    }
}
