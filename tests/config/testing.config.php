<?php

return [
    \Facile\DoctrineDDM\Factory\MetadataConfigFactory::class => [
        \Facile\DoctrineDDMTest\Assets\Entity\Person::class => [
            'discriminator_map' => [
                'student' => \Facile\DoctrineDDMTest\Assets\Entity\Student::class,
                'teacher' => \Facile\DoctrineDDMTest\Assets\Entity\Teacher::class,
            ],
        ],
    ],
];
