<?php

namespace App\Controller;

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
        return $this->render('accueil_admin/index.html.twig', [
            'controller_name' => 'AccueilAdminController',
        ]);
    }
}
