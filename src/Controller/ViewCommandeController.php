<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewCommandeController extends AbstractController
{
    /**
     * @Route("/restaurant/commandes-en-attente", name="view_commandes_attente")
     */
    public function viewCommandAttente(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user, "status" => "Attente"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'en attente'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-acceptees", name="view_commandes_acceptee")
     */
    public function viewCommandAcceptee(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user, "status" => "Acceptée"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'acceptées'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-pretes", name="view_commandes_pretes")
     */
    public function viewCommandPrete(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user, "status" => "Prête"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'prêtes'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-prise-en-charge", name="view_commandes_pec")
     */
    public function viewCommandPec(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user, "status" => "Prise en charge"]);
        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'prises en charge livreur'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-livree", name="view_commandes_livree")
     */
    public function viewCommandLivrees(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user, "status" => "Livré"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'livrées'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-totales", name="view_commandes_totales")
     */
    public function viewCommandTotales(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant'=>$user]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'type' => 'totales'
        ]);
    }
}
