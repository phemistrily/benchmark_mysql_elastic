<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Dealers;
use App\Entity\Genere;
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

        /** create generes */
        $genere[0] = new Genere("Dokument");
        $genere[1] = new Genere("Thriller");
        $genere[2] = new Genere("Horror");
        $genere[3] = new Genere("Detektywistyczna");
        $genere[4] = new Genere("Fantasy");
        $genere[5] = new Genere("Romans");
        $genere[6] = new Genere("Kucharska");
        $genere[7] = new Genere("Psychologiczna");
        $genere[8] = new Genere("Wiersze");
        $genere[9] = new Genere("Historyczne");
        $manager->persist($genere[0]);
        $manager->persist($genere[1]);
        $manager->persist($genere[2]);
        $manager->persist($genere[3]);
        $manager->persist($genere[4]);
        $manager->persist($genere[5]);
        $manager->persist($genere[6]);
        $manager->persist($genere[7]);
        $manager->persist($genere[8]);
        $manager->persist($genere[9]);

        /** create books */
        for ($i = 0; $i < 1000000; $i++) {
            $book[$i] = new Book($faker->words(6, true),$library[$faker->numberBetween(0,9)], $genere[$faker->numberBetween(0,9)], null);
            $manager->persist($book[$i]);
        }

        /** create rents */
        for ($i = 0; $i < 10000; $i++) {
            $rent = new Rent($faker->dateTime, $faker->dateTime('+1 month'),$user[$faker->numberBetween(0,999)], $book[$faker->numberBetween(0,999999)]);
            $manager->persist($rent);
        }

        /** create dealers */
        for ($i = 0; $i < 10000; $i++) {
            $dealer[$i] = new Dealers($faker->company, $faker->city, $faker->streetAddress);
            $manager->persist($dealer[$i]);
        }

        $manager->flush();
    }
}
