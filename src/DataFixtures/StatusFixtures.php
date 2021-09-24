<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         for ($i=1 ; $i<=6 ; $i++){
             $status= new Status();
             switch ($i){
                 case 1: $status->setLabel("Created");
                    break;
                 case 2: $status->setLabel("Published");
                     break;
                 case 3: $status->setLabel("Subscriptions Ended");
                     break;
                 case 4: $status->setLabel("Event happening NOW!");
                     break;
                 case 5: $status->setLabel("Event Ended");
                     break;
                 case 6: $status->setLabel("Cancelled");
                     break;
             }
             $manager->persist($status);
         }

        $manager->flush();
        $this->addReference(Status::class.$i, $status);
    }
}
