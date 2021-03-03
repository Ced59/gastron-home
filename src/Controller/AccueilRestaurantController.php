<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Entity\User;
use App\Entity\Plats;
use App\Entity\Restaurant;
class AccueilRestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant/accueil", name="restaurant")
     */
    public function index(): Response
    {
        $restaurant = $this->getUser()->getRestaurant();


       return $this->render('accueil_restaurant/index.html.twig', [
         'controller_name' => 'AccueilRestaurantController',
         'restaurant' => $restaurant
                ]);
    }

       /**
         * @Route("/restaurant/listeCommande", name="listeCommande")
         */
        public function ListeCommande(): Response
        {
            $commande = $this->getDoctrine()->getRepository(commande::class)->findAll();

             return $this->render('accueil_restaurant/liste_commande.html.twig', [
                'commandes' => $commande,
            ]);
        }
}
