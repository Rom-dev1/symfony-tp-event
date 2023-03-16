<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $faker = Factory::create('fr_FR');

        for($i = 1; $i<=15; $i++){
            $date = new DateTimeImmutable();
            $newDate = $date->modify('-'.rand(1, 100).'day');
            $startDate = $newDate->modify('+'.rand(1, 200).'day');
            $endDate = $startDate->modify('+1day');
            $event = new Event();
            $event->setName('Concert '.$i);
            $event->setDescription('lorem ipsum');
            $event->setPrice(rand(1000, 5000));
            $event->setCreatedAt($newDate);
            $event->setStartEvent($startDate);
            $event->setEndEvent($endDate);
            $manager->persist($event);
        }
        $manager->flush();
    }
}
