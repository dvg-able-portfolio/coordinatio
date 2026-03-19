<?php

declare(strict_types=1);

namespace App\Controller\Crud;

use App\Entity\Guest;
use App\Form\GuestType;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crud/guest', defaults: ['section' => '/crud/guest'])]
final class GuestController extends AbstractController
{
    #[Route(name: 'crud_guest_index', methods: ['GET'])]
    public function index(GuestRepository $guestRepository): Response
    {
        return $this->render('crud/guest/index.html.twig', [
            'guests' => $guestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'crud_guest_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guest = new Guest();
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guest);
            $entityManager->flush();

            return $this->redirectToRoute('crud_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/guest/new.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'crud_guest_show', methods: ['GET'])]
    public function show(Guest $guest): Response
    {
        return $this->render('crud/guest/show.html.twig', [
            'guest' => $guest,
        ]);
    }

    #[Route('/{id}/edit', name: 'crud_guest_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guest $guest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('crud_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/guest/edit.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'crud_guest_delete', methods: ['POST'])]
    public function delete(Request $request, Guest $guest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guest->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($guest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('crud_guest_index', [], Response::HTTP_SEE_OTHER);
    }
}
