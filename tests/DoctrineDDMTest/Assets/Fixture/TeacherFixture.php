<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Assets\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Facile\DoctrineDDMTest\Assets\Entity\Teacher;

class TeacherFixture extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new Teacher('teacher entity');

        $manager->persist($entity);
        $manager->flush();
    }
}
