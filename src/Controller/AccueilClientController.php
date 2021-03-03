<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilClientController extends AbstractController
{
    /**
     * @Route("/client/accueil", name="client")
     */
    public function index(): Response
    {

        $user = $this->getUser()->getAdress();

        $categorieRestaurants = $this->getDoctrine()->getRepository(CategorieRestaurant::class)
            ->findAll();

        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)->findAll();




        return $this->render('accueil_client/index.html.twig',
            [
                'user' => $user,
                'categorieRestaurants' => $categorieRestaurants,
                'restaurants' => $restaurant,

            ]);


    }

    /**
     * @Route("/client/accueil/{id}", name="view_resto")
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


}
