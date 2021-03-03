<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Entity\Restaurant;
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
        $idSecteur = $this->getUser()->getVille()->getSecteur()->getId();

        $categorieRestaurants = $this->getDoctrine()->getRepository(CategorieRestaurant::class)
            ->findAll();

//        $repo = $this->getDoctrine()->getRepository(CategorieRestaurant::class);
//        $categories = $repo->find(21);
//        $restaurant = $categories->getRestaurant();

        $repo = $this->getDoctrine()->getRepository(CategorieRestaurant::class);
        $restaurant = $repo->findByCategorieAndSecteur(21, $idSecteur);
        dd($restaurant);


        return $this->render('accueil_client/index.html.twig',
            [
                'user' => $user,
                'categorieRestaurants' => $categorieRestaurants,
                'restaurants' => $restaurant,

            ]);


    }


}
