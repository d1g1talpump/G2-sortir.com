<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_CA');
        for($i = 0; $i <=66; $i++){
            $event = new Event();
            $event->setName($faker->unique()->word());
            $event->setDuration($faker->numberBetween(66, 666));
            $event->setInfos($faker->unique()->text());
            $event->setMaxSub($faker->numberBetween(6, 66));
            $event->setStartDate($faker->dateTimeBetween('+6months', 'now'));
            $event->setLimitSubDate($faker->dateTimeBetween($event->getStartDate(), 'now'));
            $event->setOrganiser($this->getReference(User::class.mt_rand(0,100)));
            $event->setCampus($this->getReference(Campus::class.mt_rand(0,9)));
            $event->setPlace($this->getReference(Place::class.mt_rand(0,20)));
            $event->setStatus($this->getReference(Status::class.mt_rand(1,6)));

            $manager->persist($event);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class,
            UserFixtures::class,
            PlaceFixtures::class,
            StatusFixtures::class
        ];
    }
}
