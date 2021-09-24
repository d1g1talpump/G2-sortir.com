<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class PlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_CA');
        for ($i = 0 ; $i <= 20 ; $i++){
            $place = new Place();
            $place->setName($faker->name());
            $place->setCity($this->getReference(City::class));
            $place->setLatitude($faker->latitude(-79.76, 44.99));
            $place->setLongitude($faker->longitude(-57.10, 62.59));
            $place->setStreet($faker->streetAddress());

            $manager->persist($place);

            $this->addReference(Place::class.$i, $place);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            CityFixtures::class
        ];
    }
}
