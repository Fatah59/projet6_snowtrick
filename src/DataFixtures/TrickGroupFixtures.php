<?php

namespace App\DataFixtures;

use App\Entity\TrickGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $trickGroup = new TrickGroup();
        $trickGroup->setName('test');

        $manager->persist($trickGroup);
        $manager->flush();
    }
}
