<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Form\HabitatType;
use App\Repository\HabitatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class HabitatController extends AbstractController
{
    #[Route('/habitat/', name: 'habitat_index', methods: ['GET'])]
    public function index(HabitatRepository $habitatRepository): Response
    {
        return $this->render('habitat/index.html.twig', [
            'habitats' => $habitatRepository->findAll(),
        ]);
    }

    #[Route('/habitat/new', name: 'habitat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habitat = new Habitat();
        $form = $this->createForm(HabitatType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($habitat);
            $entityManager->flush();

            return $this->redirectToRoute('habitat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitat/new.html.twig', [
            'habitat' => $habitat,
            'form' => $form,
        ]);
    }

    #[Route('/habitat/{id}', name: 'habitat_show', methods: ['GET'])]
    public function show(Habitat $habitat): Response
    {
        return $this->render('habitat/show.html.twig', [
            'habitat' => $habitat,
        ]);
    }

    #[Route('/habitat/{id}/edit', name: 'habitat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitat $habitat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HabitatType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('habitat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('habitat/edit.html.twig', [
            'habitat' => $habitat,
            'form' => $form,
        ]);
    }

    #[Route('/habitat/{id}', name: 'habitat_delete', methods: ['POST'])]
    public function delete(Request $request, Habitat $habitat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habitat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($habitat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('habitat_index', [], Response::HTTP_SEE_OTHER);
    }
}
