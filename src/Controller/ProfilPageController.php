<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPageController extends AbstractController
{
    /**
     * @Route("/utilisateur/profil", name="profil_page")
     */
    public function index(): Response
    {
        return $this->render('profil_page/index.html.twig', [
            'controller_name' => 'ProfilPageController',
        ]);
    }
}
