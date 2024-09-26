<?php

namespace App\Controller;

use App\Entity\Species;
use App\Form\SpeciesType;
use App\Repository\SpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SpeciesController extends AbstractController
{
    #[Route('/species/', name: 'species_index', methods: ['GET'])]
    public function index(SpeciesRepository $speciesRepository): Response
    {
        return $this->render('species/index.html.twig', [
            'species' => $speciesRepository->findAll(),
        ]);
    }

    #[Route('/species/new', name: 'species_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $species = new Species();
        $form = $this->createForm(SpeciesType::class, $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($species);
            $entityManager->flush();

            return $this->redirectToRoute('species_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('species/new.html.twig', [
            'species' => $species,
            'form' => $form,
        ]);
    }

    #[Route('/species/{id}', name: 'species_show', methods: ['GET'])]
    public function show(Species $species): Response
    {
        return $this->render('species/show.html.twig', [
            'species' => $species,
        ]);
    }

    #[Route('/species/{id}/edit', name: 'species_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Species $species, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpeciesType::class, $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('species_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('species/edit.html.twig', [
            'species' => $species,
            'form' => $form,
        ]);
    }

    #[Route('/species/{id}', name: 'species_delete', methods: ['POST'])]
    public function delete(Request $request, Species $species, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$species->getId(), $request->request->get('_token'))) {
            $entityManager->remove($species);
            $entityManager->flush();
        }

        return $this->redirectToRoute('species_index', [], Response::HTTP_SEE_OTHER);
    }
}
