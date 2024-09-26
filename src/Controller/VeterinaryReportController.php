<?php

namespace App\Controller;

use App\Entity\VeterinaryReport;
use App\Form\VeterinaryReportType;
use App\Repository\VeterinaryReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class VeterinaryReportController extends AbstractController
{
    #[Route('/veterinary_report/', name: 'veterinary_report_index', methods: ['GET'])]
    public function index(VeterinaryReportRepository $veterinaryReportRepository): Response
    {
        return $this->render('veterinary_report/index.html.twig', [
            'veterinary_reports' => $veterinaryReportRepository->findAll(),
        ]);
    }

    #[Route('/veterinary_report/new', name: 'veterinary_report_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veterinaryReport = new VeterinaryReport();
        $form = $this->createForm(VeterinaryReportType::class, $veterinaryReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veterinaryReport);
            $entityManager->flush();

            return $this->redirectToRoute('veterinary_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinary_report/new.html.twig', [
            'veterinary_report' => $veterinaryReport,
            'form' => $form,
        ]);
    }

    #[Route('/veterinary_report/{id}', name: 'veterinary_report_show', methods: ['GET'])]
    public function show(VeterinaryReport $veterinaryReport): Response
    {
        return $this->render('veterinary_report/show.html.twig', [
            'veterinary_report' => $veterinaryReport,
        ]);
    }

    #[Route('/veterinary_report/{id}/edit', name: 'veterinary_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VeterinaryReport $veterinaryReport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaryReportType::class, $veterinaryReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('veterinary_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('veterinary_report/edit.html.twig', [
            'veterinary_report' => $veterinaryReport,
            'form' => $form,
        ]);
    }

    #[Route('/veterinary_report/{id}', name: 'veterinary_report_delete', methods: ['POST'])]
    public function delete(Request $request, VeterinaryReport $veterinaryReport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinaryReport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($veterinaryReport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('veterinary_report_index', [], Response::HTTP_SEE_OTHER);
    }
}
