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

        // formulaire boutton ChoiceType
        //  $form = $this->createForm(CategorieRestaurantType::class);

        $categorieRestaurants = $this->getDoctrine()->getRepository(CategorieRestaurant::class)
            ->findAll();


        $typeRestaurant = 10;
        // $restaurant = $this->getUserAndCategorieRestaurantFromRestaurant($typeRestaurant);

        //requete sur restaurant conportant un findby [id-categorierestaurant]


        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $restaurant = $repo->findBy(['categorieRestaurants' => 10 ]);



        return $this->render('accueil_client/index.html.twig',
            [
                'user' => $user,
                'categorieRestaurants' => $categorieRestaurants,
                'restaurants' => $restaurant,

            ]);


    }


}
