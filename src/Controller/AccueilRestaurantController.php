<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilRestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant/accueil", name="restaurant")
     */
    public function index(): Response
    {
        $restaurant = $this->getUser()->getRestaurant();


        return $this->render('accueil_restaurant/index.html.twig', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * @Route("/restaurant/listeCommande", name="listeCommande")
     */
    public function ListeCommande(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user]);


        return $this->render('accueil_restaurant/liste_commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }
}
