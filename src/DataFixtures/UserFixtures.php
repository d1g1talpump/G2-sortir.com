<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('en_CA');

        for($i = 0; $i <=20; $i++){

            $user = new User();
            $hash = $this->encoder->encodePassword($user, 'password');
            $user->setPseudo($faker->userName());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email());
            $user->setTelephone($faker->phoneNumber());
            $user->setAdmin(false);
            $user->setActive(true);
            $user->setCampus($this->getReference(Campus::class.mt_rand(0,9)));
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($hash);

            $manager->persist($user);
            $this->addReference(User::class.$i, $user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return [
            'firstLoad', 'user', 'event'];
    }
}
