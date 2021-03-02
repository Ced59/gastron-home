<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Repository\RestaurantRepository;
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

//        $repositoryRestaurant = $this->getDoctrine()->getRepository(RestaurantRepository::class);
//        $Restaurants = $repositoryRestaurant->findby([], ["" => "DESC"]);

        return $this->render('accueil_client/index.html.twig',
//            [
//            'Restaurants' => $Restaurants,]
        )
//
//        ->add('localisation', EntityType::class, [
//            'class' => CategorieRestaurant::class,
//            'choice_label' => function ($categorieRestaurant) {
//                return $categorieRestaurant->getLibelle();
//            }
//        ])
            ;


    }


}
