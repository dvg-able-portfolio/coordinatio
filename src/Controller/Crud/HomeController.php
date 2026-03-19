<?php

declare(strict_types=1);

namespace App\Controller\Crud;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/crud')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'crud_home')]
    public function index(): Response
    {
        return $this->render('crud/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
