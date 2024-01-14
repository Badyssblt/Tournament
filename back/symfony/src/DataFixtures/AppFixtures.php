<?php

namespace App\DataFixtures;

use App\Entity\Tournament;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $tournament = array();

        for ($i = 0; $i < 10; $i++) {
            $tournament[$i] = new Tournament();
            $tournament[$i]->setName($faker->name());
            $tournament[$i]->setGame("Test Game");
            $manager->persist($tournament[$i]);
        }

        for ($i = 0; $i < 10; $i++) {
            $user[$i] = new User();
            $user[$i]->setPassword($faker->password());
            $user[$i]->setEmail($faker->email());
            $manager->persist($user[$i]);
        }


        $manager->flush();
    }
}
