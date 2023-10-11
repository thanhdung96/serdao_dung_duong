<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $lstSampleUsers = [];

        $obama = new User();
        $obama->setFirstName('Barack');
        $obama->setLastName('Obama');
        $obama->setAddress('White House');
        $lstSampleUsers[] = $obama;

        $spears = new User();
        $spears->setFirstName('Britney');
        $spears->setLastName('Spears');
        $spears->setAddress('America');
        $lstSampleUsers[] = $spears;

        $diCaprio = new User();
        $diCaprio->setFirstName('Leonardo');
        $diCaprio->setLastName('DiCaprio');
        $diCaprio->setAddress('Titanic');
        $lstSampleUsers[] = $diCaprio;

        foreach ($lstSampleUsers as $sampleUser) {
            $manager->persist($sampleUser);
        }
        $manager->flush();
    }
}
