<?php

namespace App\Controller;

use App\Entity\Genere;
use App\Form\GenereType;
use App\Repository\GenereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genere')]
class GenereController extends AbstractController
{
    #[Route('/', name: 'genere_index', methods: ['GET'])]
    public function index(GenereRepository $genereRepository): Response
    {
        return $this->render('genere/index.html.twig', [
            'generes' => $genereRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'genere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $genere = new Genere();
        $form = $this->createForm(GenereType::class, $genere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genere);
            $entityManager->flush();

            return $this->redirectToRoute('genere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genere/new.html.twig', [
            'genere' => $genere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'genere_show', methods: ['GET'])]
    public function show(Genere $genere): Response
    {
        return $this->render('genere/show.html.twig', [
            'genere' => $genere,
        ]);
    }

    #[Route('/{id}/edit', name: 'genere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Genere $genere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenereType::class, $genere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('genere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genere/edit.html.twig', [
            'genere' => $genere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'genere_delete', methods: ['POST'])]
    public function delete(Request $request, Genere $genere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($genere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('genere_index', [], Response::HTTP_SEE_OTHER);
    }
}
