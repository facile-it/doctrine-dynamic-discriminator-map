<?php

declare(strict_types=1);

namespace Facile\DoctrineDDMTest\Functional;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader as FixtureLoader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Facile\DoctrineDDM\MetadataListener;
use Facile\DoctrineDDMTest\Assets\Entity\Person;
use Facile\DoctrineDDMTest\Assets\Entity\Student;
use Facile\DoctrineDDMTest\Assets\Entity\Teacher;
use Facile\DoctrineDDMTest\Assets\Fixture\PersonFixture;
use Facile\DoctrineDDMTest\Assets\Fixture\StudentFixture;
use Facile\DoctrineDDMTest\Assets\Fixture\TeacherFixture;
use Facile\DoctrineDDMTest\Framework\TestCase;

class MetadataListenerTest extends TestCase
{
    /**
     * @var MetadataListener
     */
    protected $listener;

    protected function setUp()
    {
        parent::setUp();

        $this->dropDb();
        $this->createDb();

        $loader = new FixtureLoader();
        $loader->addFixture(new PersonFixture());
        $loader->addFixture(new StudentFixture());
        $loader->addFixture(new TeacherFixture());
        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEntityManager(), $purger);
        $executor->execute($loader->getFixtures());
    }

    public function testFoo()
    {
        // adding a teacher person
        $teacherRepo = $this->getEntityManager()->getRepository(Teacher::class);
        $teachers = $teacherRepo->findAll();

        $this->assertCount(1, $teachers);
        $this->assertEquals('teacher entity', $teachers[0]->getName());

        // adding a student
        $studentRepo = $this->getEntityManager()->getRepository(Student::class);
        $students = $studentRepo->findAll();

        $this->assertCount(1, $students);
        $this->assertEquals('student entity', $students[0]->getName());

        // adding a generic person
        $personRepo = $this->getEntityManager()->getRepository(Person::class);
        $persons = $personRepo->findAll();

        $this->assertCount(3, $persons);
    }
}
