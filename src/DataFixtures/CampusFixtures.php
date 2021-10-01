<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
//        $faker = \Faker\Factory::create('en_CA');
        for ($i = 0; $i <= 2; $i++) {
            $campus = new Campus();
            switch ($i) {
                case 0: $campus->setName('Niort');
                    break;
                case 1: $campus->setName('Rennes');
                    break;
                case 2: $campus->setName('Nantes');
            }
            $manager->persist($campus);
            $manager->flush();
            $this->addReference(Campus::class . $i, $campus);
        }
    }

    public static function getGroups(): array
    {
        return [
            'firstLoad', 'user', 'event', 'campus'];
    }
}
