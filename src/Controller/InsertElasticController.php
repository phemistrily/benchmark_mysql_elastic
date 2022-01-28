<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertElasticController extends AbstractController
{
    public function __construct(
//        private PaginatedFinderInterface $finder,
        private ObjectPersisterInterface $post,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/insert_elastic', name: 'insert_elastic')]
    public function index(): Response
    {
        /** @var Factory $faker - create faker */
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user[$i] = new User($faker->firstName, $faker->lastName, $faker->email);
        }
        $startElastic10 = microtime();
        $this->post->insertMany($user);
        $endElastic10 = microtime();
        $startMysql10 = microtime();
        for ($i = 0; $i < 10; $i++) {
            $this->entityManager->persist($user[$i]);
        }
        $this->entityManager->flush();
        $endMysql10 = microtime();

        $startElastic10 = explode(' ', $startElastic10);
        $endElastic10 = explode(' ', $endElastic10);
        $timeElastic10 = ($endElastic10[0]+$endElastic10[1])-($startElastic10[0]+$startElastic10[1]);

        $startMysql10 = explode(' ', $startMysql10);
        $endMysql10 = explode(' ', $endMysql10);
        $timeSql10 = ($endMysql10[0]+$endMysql10[1])-($startMysql10[0]+$startMysql10[1]);

//        dump('dla 10');
//        dump($timeElastic10);
//        dump($timeSql10);

        for ($i = 0; $i < 100; $i++) {
            $user[$i] = new User($faker->firstName, $faker->lastName, $faker->email);
        }
        $startElastic100 = microtime();
        $this->post->insertMany($user);
        $endElastic100 = microtime();
        $startMysql100 = microtime();
        for ($i = 0; $i < 100; $i++) {
            $this->entityManager->persist($user[$i]);
        }
        $endMysql100 = microtime();

        $startElastic100 = explode(' ', $startElastic100);
        $endElastic100 = explode(' ', $endElastic100);
        $timeElastic100 = ($endElastic100[0]+$endElastic100[1])-($startElastic100[0]+$startElastic100[1]);

        $startMysql100 = explode(' ', $startMysql100);
        $endMysql100 = explode(' ', $endMysql100);
        $timeSql100 = ($endMysql100[0]+$endMysql100[1])-($startMysql100[0]+$startMysql100[1]);
//
//        dump('dla 100');
//        dump($timeElastic100);
//        dump($timeSql100);

        for ($i = 0; $i < 1000; $i++) {
            $user[$i] = new User($faker->firstName, $faker->lastName, $faker->email);
        }
        $startElastic1000 = microtime();
        $this->post->insertMany($user);
        $endElastic1000 = microtime();
        $startMysql1000 = microtime();
        for ($i = 0; $i < 1000; $i++) {
            $this->entityManager->persist($user[$i]);
        }
        $endMysql1000 = microtime();

        $startElastic1000 = explode(' ', $startElastic1000);
        $endElastic1000 = explode(' ', $endElastic1000);
        $timeElastic1000 = ($endElastic1000[0]+$endElastic1000[1])-($startElastic1000[0]+$startElastic1000[1]);

        $startMysql1000 = explode(' ', $startMysql1000);
        $endMysql1000 = explode(' ', $endMysql1000);
        $timeSql1000 = ($endMysql1000[0]+$endMysql1000[1])-($startMysql1000[0]+$startMysql1000[1]);

//        dump('dla 1000');
//        dump($timeElastic1000);
//        dump($timeSql1000);

        for ($i = 0; $i < 10000; $i++) {
            $user[$i] = new User($faker->firstName, $faker->lastName, $faker->email);
        }
        $startElastic10000 = microtime();
        $this->post->insertMany($user);
        $endElastic10000 = microtime();
        $startMysql10000 = microtime();
        for ($i = 0; $i < 10000; $i++) {
            $this->entityManager->persist($user[$i]);
        }
        $endMysql10000 = microtime();

        $startElastic10000 = explode(' ', $startElastic10000);
        $endElastic10000 = explode(' ', $endElastic10000);
        $timeElastic10000 = ($endElastic10000[0]+$endElastic10000[1])-($startElastic10000[0]+$startElastic10000[1]);

        $startMysql10000 = explode(' ', $startMysql10000);
        $endMysql10000 = explode(' ', $endMysql10000);
        $timeSql10000 = ($endMysql10000[0]+$endMysql10000[1])-($startMysql10000[0]+$startMysql10000[1]);

//        dump('dla 10000');
//        dump($timeElastic10000);
//        dump($timeSql10000);

        return $this->render('insert_elastic/index.html.twig', [
            'controller_name' => 'IndexController',
            'data' => [
                '10elastic' => $timeElastic10,
                '10sql' => $timeSql10,
                '100elastic' => $timeElastic100,
                '100sql' => $timeSql100,
                '1000elastic' => $timeElastic1000,
                '1000sql' => $timeSql1000,
                '10000elastic' => $timeElastic10000,
                '10000sql' => $timeSql10000,
            ]
        ]);
    }
}
