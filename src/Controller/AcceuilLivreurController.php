<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Livreur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilLivreurController extends AbstractController
{
    /**
     * @Route("/livreur/accueil", name="livreur")
     */
    public function index(): Response
    {
        $user = $this->getUser()->getLivreur()->getId();
        $repo = $this->getDoctrine()->getRepository(Livraison::class);
        $livraison = $repo->findBy(['livreur'=>$user, 'status'=>'Prise en charge livreur']);

        return $this->render('acceuil_livreur/index.html.twig', [
            'controller_name' => 'AcceuilLivreurController',
            'livraisons' => $livraison
        ]);
    }

    /**
     * @Route("/livreur/validation/{id}", name="validation_commande")
     */
    public function validateComand(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Livraison::class);
        $livraison = $repository->find($id);
        $livraison->setStatus('Livré');
        $livraison->setDateLivraison(new \DateTime());
        $livraison->getCommande()->setStatus("Livré");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livraison);
        $entityManager->flush();

        return $this->render('acceuil_livreur/validation.html.twig', [
            'controller_name' => 'AcceuilLivreurController',
            'livraison' => $livraison
        ]);
    }
}
