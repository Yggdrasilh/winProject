<?php

namespace App\Controller;

use App\Repository\WineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WineController extends AbstractController
{
    #[Route('/', name: 'app_wine')]
    public function index(Request $request, WineRepository $winerepo): Response
    {
        $wines = $winerepo->findAll();

        return $this->render('wine/index.html.twig', [
            'controller_name' => 'WineController', 'wines' => $wines,
        ]);
    }
}
