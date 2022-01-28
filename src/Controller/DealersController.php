<?php

namespace App\Controller;

use App\Entity\Dealers;
use App\Form\DealersType;
use App\Repository\DealersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dealers')]
class DealersController extends AbstractController
{
    #[Route('/', name: 'dealers_index', methods: ['GET'])]
    public function index(DealersRepository $dealersRepository): Response
    {
        return $this->render('dealers/index.html.twig', [
            'dealers' => $dealersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'dealers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dealer = new Dealers();
        $form = $this->createForm(DealersType::class, $dealer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dealer);
            $entityManager->flush();

            return $this->redirectToRoute('dealers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dealers/new.html.twig', [
            'dealer' => $dealer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'dealers_show', methods: ['GET'])]
    public function show(Dealers $dealer): Response
    {
        return $this->render('dealers/show.html.twig', [
            'dealer' => $dealer,
        ]);
    }

    #[Route('/{id}/edit', name: 'dealers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dealers $dealer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DealersType::class, $dealer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dealers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dealers/edit.html.twig', [
            'dealer' => $dealer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'dealers_delete', methods: ['POST'])]
    public function delete(Request $request, Dealers $dealer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dealer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dealer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dealers_index', [], Response::HTTP_SEE_OTHER);
    }
}
