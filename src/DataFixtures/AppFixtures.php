<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Pokemon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i=1; $i < 4;) {
            $faker = Faker\Factory::create();

            $pokemon = new Pokemon();
            $pokemon->setName($faker->userName);
            $pokemon->setPrimaryType($i = 0 ? "Fire" : $i = 1 ? "Grass" : "Water");
            $pokemon->setPrimaryType(null);
            $pokemon->setPokedexNumber("00 ~ $i");

            $manager->persist($pokemon);
            $i++;
        }

        $manager->flush();
    }
}
