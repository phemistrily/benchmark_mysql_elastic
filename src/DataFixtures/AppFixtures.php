<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Library;
use App\Entity\Rent;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /** @var Factory $faker - create faker */
        $faker = Factory::create();
        $library = null;
        /** create libraries */
        for ($i = 0; $i < 10; $i++) {
            $library[$i] = new Library($faker->company, $faker->city, $faker->streetAddress);
            $manager->persist($library[$i]);
        }

        for ($i = 0; $i < 1000; $i++) {
            $user[$i] = new User($faker->firstName, $faker->lastName, $faker->email);
            $manager->persist($user[$i]);
        }

        /** create books */
        for ($i = 0; $i < 1000000; $i++) {
            $book[$i] = new Book($faker->words(6, true),$library[$faker->numberBetween(0,9)]);
            $manager->persist($book[$i]);
        }

        for ($i = 0; $i < 10000; $i++) {
            $rent = new Rent($faker->dateTime, $faker->dateTime('+1 month'),$user[$faker->numberBetween(0,999)], $book[$faker->numberBetween(0,999999)]);
            $manager->persist($rent);
        }

        $manager->flush();
    }
}
