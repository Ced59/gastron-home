<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Entity\Commande;
use App\Entity\Plats;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/client")
 */
class AccueilClientController extends AbstractController
{
    /**
     * @Route("/accueil", name="client")
     */
    public function index(): Response
    {

        $user = $this->getUser()->getAdress();
        $userId = $this->getUser()->getId();
        $idSecteur = $this->getUser()->getVille()->getSecteur()->getId();

        $commande = $this->getDoctrine()->getRepository(Commande::class);
        $commandeUser = $commande->findBy(['utilisateur'=> $userId]);

        $categorieRestaurants = $this->getDoctrine()->getRepository(CategorieRestaurant::class)
            ->findAll();

        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)->findBySecteur($idSecteur);

        return $this->render('accueil_client/index.html.twig',
            [
                'commandUser' => $commandeUser,
                'user' => $user,
                'categorieRestaurants' => $categorieRestaurants,
                'restaurants' => $restaurant,

            ]);
    }

    /**
     * @Route("/accueil/{id}", name="view_resto")
     */
    public function viewRestaurant($id): Response
    {
        $user = $this->getUser()->getAdress();
        $idSecteur = $this->getUser()->getVille()->getSecteur()->getId();

        $categorieRestaurants = $this->getDoctrine()->getRepository(CategorieRestaurant::class)
            ->findAll();

        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repo->findByCategorieAndSecteur($id, $idSecteur);

        return $this->render('accueil_client/index.html.twig',
            [
                'user' => $user,
                'categorieRestaurants' => $categorieRestaurants,
                'restaurants' => $restaurant,
            ]);
    }


    /**
     * @Route("/restaurant/{id}/menu", name="restaurant_menu")
     */
    public function viewRestaurantMenu(int $id): Response
    {
        $plats = $this->getDoctrine()->getRepository(Plats::class)->findByRestaurantAndPositifStock($id);
        return $this->render('restaurant/plat.html.twig',[
            'plats' => $plats
        ]);
    }

}
