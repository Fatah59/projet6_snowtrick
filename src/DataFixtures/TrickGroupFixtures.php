<?php

namespace App\DataFixtures;

use App\Entity\TrickGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'grabs',
            'rotation',
            'old school',
            'slides',
            'flips',
            'tweaks'
        );

        foreach ($names as $name) {
            $slug->slugify($name);

            $trickGroup = new TrickGroup();
            $trickGroup->setName($name);

            $this->addReference($trickGroup);

            $manager->persist($trickGroup);
            $manager->flush();
        }
    }
}
