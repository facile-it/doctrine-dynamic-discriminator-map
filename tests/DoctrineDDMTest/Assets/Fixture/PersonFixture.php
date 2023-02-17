<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Assets\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Facile\DoctrineDDMTest\Assets\Entity\Person;

class PersonFixture extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new Person('person entity');

        $manager->persist($entity);
        $manager->flush();
    }
}
