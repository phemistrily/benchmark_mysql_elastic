<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use FOS\ElasticaBundle\Index\IndexManager;
use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteElasticController extends AbstractController
{
    public function __construct(
        private PaginatedFinderInterface $finder,
        private ObjectPersisterInterface $post,
        private EntityManagerInterface $entityManager,
        private IndexManager $indexManager,
    ) {
    }

    #[Route('/delete_elastic', name: 'delete_elastic')]
    public function index(): Response
    {
        $data = $this->finder->find('', 10);
        if (count($data) < 10) {
            die ('brak danych - uzupełnij dane');
        }
        dump($data);
        $startElastic10 = microtime();
        foreach ($data as $item) {
            $this->post->deleteOne($item);
        }
        $endElastic10 = microtime();
        $startMysql10 = microtime();
//        foreach ($data as $item) {
//            $this->entityManager->remove($item);
//        }
        $this->entityManager->flush();
        $endMysql10 = microtime();
        $startElastic10 = explode(' ', $startElastic10);
        $endElastic10 = explode(' ', $endElastic10);
        $timeElastic10 = ($endElastic10[0]+$endElastic10[1])-($startElastic10[0]+$startElastic10[1]);

        $startMysql10 = explode(' ', $startMysql10);
        $endMysql10 = explode(' ', $endMysql10);
        $timeSql10 = ($endMysql10[0]+$endMysql10[1])-($startMysql10[0]+$startMysql10[1]);
        $this->indexManager->getIndex('user')->refresh();
        sleep(20);
//        dump('dla 10');
//        dump($timeElastic10);
//        dump($timeSql10);

//        die('pp');
        $data = $this->finder->find('', 100);
        if (count($data) < 100) {
            die ('brak danych - uzupełnij dane');
        }
        $startElastic100 = microtime();
        $endElastic100 = microtime();
        $startMysql100 = microtime();
        foreach ($data as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();
        $endMysql100 = microtime();
//        die('t');
        $startElastic100 = explode(' ', $startElastic100);
        $endElastic100 = explode(' ', $endElastic100);
        $timeElastic100 = ($endElastic100[0]+$endElastic100[1])-($startElastic100[0]+$startElastic100[1]);

        $startMysql100 = explode(' ', $startMysql100);
        $endMysql100 = explode(' ', $endMysql100);
        $timeSql100 = ($endMysql100[0]+$endMysql100[1])-($startMysql100[0]+$startMysql100[1]);
        $this->indexManager->getIndex('user')->refresh();
        sleep(20);
//
//        dump('dla 100');
//        dump($timeElastic100);
//        dump($timeSql100);

        $data = $this->finder->find('', 1000);
        if (count($data) < 1000) {
            die ('brak danych - uzupełnij dane');
        }
        $startElastic1000 = microtime();
        foreach ($data as $item) {
            $this->post->deleteOne($item);
        }
        $endElastic1000 = microtime();
        $startMysql1000 = microtime();
        foreach ($data as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();
        $endMysql1000 = microtime();

        $startElastic1000 = explode(' ', $startElastic1000);
        $endElastic1000 = explode(' ', $endElastic1000);
        $timeElastic1000 = ($endElastic1000[0]+$endElastic1000[1])-($startElastic1000[0]+$startElastic1000[1]);

        $startMysql1000 = explode(' ', $startMysql1000);
        $endMysql1000 = explode(' ', $endMysql1000);
        $timeSql1000 = ($endMysql1000[0]+$endMysql1000[1])-($startMysql1000[0]+$startMysql1000[1]);
        $this->indexManager->getIndex('user')->refresh();
        sleep(20);

//        dump('dla 1000');
//        dump($timeElastic1000);
//        dump($timeSql1000);

        $data = $this->finder->find('', 10000);
        if (count($data) < 10000) {
            die ('brak danych - uzupełnij dane');
        }
        $startElastic10000 = microtime();
        foreach ($data as $item) {
            $this->post->deleteOne($item);
        }
        $endElastic10000 = microtime();
        $startMysql10000 = microtime();
        foreach ($data as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();
        $endMysql10000 = microtime();

        $startElastic10000 = explode(' ', $startElastic10000);
        $endElastic10000 = explode(' ', $endElastic10000);
        $timeElastic10000 = ($endElastic10000[0]+$endElastic10000[1])-($startElastic10000[0]+$startElastic10000[1]);

        $startMysql10000 = explode(' ', $startMysql10000);
        $endMysql10000 = explode(' ', $endMysql10000);
        $timeSql10000 = ($endMysql10000[0]+$endMysql10000[1])-($startMysql10000[0]+$startMysql10000[1]);
        $this->indexManager->getIndex('user')->refresh();
        sleep(20);

//        dump('dla 10000');
//        dump($timeElastic10000);
//        dump($timeSql10000);

        return $this->render('delete_elastic/index.html.twig', [
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
