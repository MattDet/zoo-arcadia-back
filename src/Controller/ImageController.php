<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ImageController extends AbstractController
{
    #[Route('/image/', name: 'image_index', methods: ['GET'])]
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    #[Route('/image/new', name: 'image_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('path')->getData(); // Assurez-vous que 'path' est le champ du formulaire

            if ($file) {
                $fileName = $fileUploader->upload($file);
                $image->setPath($fileName);
            }
    
            $entityManager->persist($image);
            $entityManager->flush();
    
            return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('image/new.html.twig', [
            'image' => $image,
            'form' => $form->createView(), // Utilisez createView() pour rendre le formulaire
        ]);
    }
    
    #[Route('/image/{id}', name: 'image_show', methods: ['GET'])]
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/image/{id}/edit', name: 'image_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Image $image, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('path')->getData(); // Assurez-vous que 'path' est le champ du formulaire
    
            if ($file) {
                $fileName = $fileUploader->upload($file);
                $image->setPath($fileName);
            }
    
            $entityManager->flush();
    
            return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('image/edit.html.twig', [
            'image' => $image,
            'form' => $form->createView(), // Utilisez createView() pour rendre le formulaire
        ]);
    }
    
    #[Route('/image/{id}', name: 'image_delete', methods: ['POST'])]
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            // Remove the image file from the filesystem
            $filePath = $this->getParameter('kernel.project_dir').'/public/uploads/'.$image->getPath();
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
    }
}
