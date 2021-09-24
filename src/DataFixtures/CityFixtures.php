<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_CA');
        for ($i = 0; $i<=30; $i++){
            $city = new City();
            $city->setName($faker->city());
            $city->setPostalCode($faker->postcode());
            $manager->persist($city);

            $this->addReference(City::class.$i, $city);
        }


        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            'firstLoad', 'city', 'place', 'event'];
    }
}
