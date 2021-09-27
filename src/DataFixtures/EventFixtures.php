<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\City;
use App\Repository\StatusRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;

class EventFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_CA');

        for($i = 0; $i <=100; $i++){

            $event = new Event();

            $event->setName($faker->unique()->word());
            $event->setDuration($faker->numberBetween(66, 666));
            $event->setInfos($faker->realText(200));
            $event->setMaxSub($faker->numberBetween(6, 66));
            $event->setStartDate($faker->dateTimeInInterval('now', '+6months'));
            $event->setLimitSubDate($faker->dateTimeInInterval($event->getStartDate(), '-1months'));
            $event->setOrganiser($this->getReference(User::class.mt_rand(0,50)));
            $event->setCampus($this->getReference(Campus::class.mt_rand(0,15)));
            $event->setPlace($this->getReference(Place::class.mt_rand(0,30)));
            $event->setStatus($this->getReference(Status::class.mt_rand(1,7)));


            $manager->persist($event);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class,
            UserFixtures::class,
            PlaceFixtures::class,
            StatusFixtures::class,
            CityFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return [
            'firstLoad', 'event'];
    }
}
