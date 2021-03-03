<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewCommandeController extends AbstractController
{
    /**
     * @Route("/view/commande", name="view_commande")
     */
    public function index(): Response
    {
        return $this->render('view_commande/index.html.twig', [
            'controller_name' => 'ViewCommandeController',
        ]);
    }
}
