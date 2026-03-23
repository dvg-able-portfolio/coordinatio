<?php

namespace App\Controller\Crud;

use App\Entity\ServiceCategory;
use App\Form\ServiceCategoryType;
use App\Repository\ServiceCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crud/service-category')]
final class ServiceCategoryController extends AbstractController
{
    #[Route(name: 'crud_service_category_index', methods: ['GET'])]
    public function index(ServiceCategoryRepository $serviceCategoryRepository): Response
    {
        return $this->render('crud/service-category/index.html.twig', [
            'service_categories' => $serviceCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'crud_service_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serviceCategory = new ServiceCategory();
        $form = $this->createForm(ServiceCategoryType::class, $serviceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceCategory);
            $entityManager->flush();

            return $this->redirectToRoute('crud_service_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/service-category/new.html.twig', [
            'service_category' => $serviceCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'crud_service_category_show', methods: ['GET'])]
    public function show(ServiceCategory $serviceCategory): Response
    {
        return $this->render('crud/service-category/show.html.twig', [
            'service_category' => $serviceCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'crud_service_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceCategory $serviceCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceCategoryType::class, $serviceCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('crud_service_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/service-category/edit.html.twig', [
            'service_category' => $serviceCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'crud_service_category_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceCategory $serviceCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($serviceCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crud_service_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
