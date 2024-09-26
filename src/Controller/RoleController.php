<?php

namespace App\Controller;

use App\Entity\Role;
use App\Form\RoleType;
use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RoleController extends AbstractController
{
    #[Route('/role/', name: 'role_index', methods: ['GET'])]
    public function index(RoleRepository $roleRepository): Response
    {
        return $this->render('role/index.html.twig', [
            'roles' => $roleRepository->findAll(),
        ]);
    }

    #[Route('/role/new', name: 'role_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/new.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/role/{id}', name: 'role_show', methods: ['GET'])]
    public function show(Role $role): Response
    {
        return $this->render('role/show.html.twig', [
            'role' => $role,
        ]);
    }

    #[Route('/role/{id}/edit', name: 'role_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('role/edit.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/role/{id}', name: 'role_delete', methods: ['POST'])]
    public function delete(Request $request, Role $role, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $entityManager->remove($role);
            $entityManager->flush();
        }

        return $this->redirectToRoute('role_index', [], Response::HTTP_SEE_OTHER);
    }
}
