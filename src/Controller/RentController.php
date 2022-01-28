<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\RentType;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rent')]
class RentController extends AbstractController
{
    #[Route('/', name: 'rent_index', methods: ['GET'])]
    public function index(RentRepository $rentRepository): Response
    {
        return $this->render('rent/index.html.twig', [
            'rents' => $rentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'rent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rent/new.html.twig', [
            'rent' => $rent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rent_show', methods: ['GET'])]
    public function show(Rent $rent): Response
    {
        return $this->render('rent/show.html.twig', [
            'rent' => $rent,
        ]);
    }

    #[Route('/{id}/edit', name: 'rent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rent $rent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rent/edit.html.twig', [
            'rent' => $rent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rent_delete', methods: ['POST'])]
    public function delete(Request $request, Rent $rent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rent->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rent_index', [], Response::HTTP_SEE_OTHER);
    }
}
