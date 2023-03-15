<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   

        for($i = 0; $i<5; $i++){
            $date = new DateTimeImmutable();
            $event = new Event();
            $event->setName("Test");
            $event->setPrice("4000");
            $event->setCreatedAt($date);
            $event->setStartEvent($date);
            $event->setEndEvent($date);
            $manager->persist($event);
        }
        $manager->flush();
    }
}
