<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Assets\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Facile\DoctrineDDMTest\Assets\Entity\Student;

class StudentFixture extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new Student('student entity');

        $manager->persist($entity);
        $manager->flush();
    }
}
