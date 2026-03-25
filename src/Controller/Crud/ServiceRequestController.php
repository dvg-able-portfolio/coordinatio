<?php

declare(strict_types=1);

namespace App\Controller\Crud;

use App\Entity\ServiceRequest;
use App\Form\ServiceRequestType;
use App\Repository\ServiceRequestRepository;
use App\Service\Crud\Guard\CreationGuard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crud/service-request', defaults: ['section' => '/crud/service-request'])]
final class ServiceRequestController extends AbstractController
{
    #[Route(name: 'crud_service_request_index', methods: ['GET'])]
    public function index(ServiceRequestRepository $serviceRequestRepository): Response
    {
        return $this->render('crud/service-request/index.html.twig', [
            'service_requests' => $serviceRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'crud_service_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CreationGuard $creationGuard): Response
    {
        $result = $creationGuard->guard(ServiceRequest::class);
        if ($result->isAllowed() === false) {
            $this->addFlash(...$result->getFlashMessage());
            return $this->redirectToRoute('crud_service_request_index');
        }

        $serviceRequest = new ServiceRequest();
        $form = $this->createForm(ServiceRequestType::class, $serviceRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceRequest);
            $entityManager->flush();

            return $this->redirectToRoute('crud_service_request_index', [], Response::HTTP_SEE_OTHER);
        }

        $response = $this->render('crud/service-request/new.html.twig', [
            'service_request' => $serviceRequest,
            'form' => $form,
        ]);

        //Use HTTP headers to prevent caching
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    #[Route('/{id}', name: 'crud_service_request_show', methods: ['GET'])]
    public function show(ServiceRequest $serviceRequest): Response
    {
        return $this->render('crud/service-request/show.html.twig', [
            'service_request' => $serviceRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'crud_service_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceRequest $serviceRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceRequestType::class, $serviceRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('crud_service_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/service-request/edit.html.twig', [
            'service_request' => $serviceRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'crud_service_request_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceRequest $serviceRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $serviceRequest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($serviceRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crud_service_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
