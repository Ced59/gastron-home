<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilLivreurController extends AbstractController
{
    /**
     * @Route("/livreur/accueil", name="livreur")
     */
    public function index(): Response
    {
        return $this->render('acceuil_livreur/index.html.twig', [
            'controller_name' => 'AcceuilLivreurController',
        ]);
    }
}
