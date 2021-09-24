<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('en_CA');
        for($i = 0; $i <=9; $i++){
            $campus = new Campus();
            $campus->setName($faker->unique()->word());

            $manager->persist($campus);
            $this->addReference(Campus::class.$i, $campus);
        }

        $manager->flush();
    }
}
