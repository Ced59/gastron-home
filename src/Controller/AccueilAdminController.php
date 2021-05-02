<?php

namespace App\Controller;

use App\Entity\CategoriePlats;
use App\Entity\CategorieRestaurant;
use App\Entity\Restaurant;
use App\Entity\Secteur;
use App\Entity\User;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilAdminController extends AbstractController
{
    /**
     * @Route("/admin/accueil", name="admin")
     */
    public function index(): Response
    {
        $categoriePlat = $this->getDoctrine()->getRepository(CategoriePlats::class)->findAll();

        $categorieRestaurant = $this->getDoctrine()->getRepository(CategorieRestaurant::class)->findAll();

        $secteur = $this->getDoctrine()->getRepository(Secteur::class)->findAll();

        $ville = $this->getDoctrine()->getRepository(Ville::class)->findAll();

        $user = $this->getUser()->getRoles();

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $client = $userRepo->findByRole('["ROLE_CLIENT"]');

        $restaurant = $userRepo->findByRole('["ROLE_RESTO"]');

        $livreur = $userRepo->findByRole('["ROLE_LIVREUR"]');


        return $this->render('accueil_admin/index.html.twig', [
            'controller_name' => 'AccueilAdminController',
            'categoriePlat' => $categoriePlat,
            'categorieRestaurant' => $categorieRestaurant ,
            'secteur' => $secteur,
            'ville' => $ville,
            'client' => $client,
            'restaurant' => $restaurant,
            'livreur' => $livreur
        ]);
    }
}
