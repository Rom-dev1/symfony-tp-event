<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
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

        $user = new User();
        $user->setEmail('test@mail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user, 'password'));
        $user->setName('test');
        $manager->persist($user);

        $manager->flush();
    }
}
