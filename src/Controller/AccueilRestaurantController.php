<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilRestaurantController extends AbstractController
{
    /**
     * @Route("/accueil/restaurant", name="restaurant")
     */
    public function index(): Response
    {
        return $this->render('accueil_restaurant/index.html.twig', [
            'controller_name' => 'AccueilRestaurantController',
        ]);
    }
}
