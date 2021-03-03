<?php

namespace App\Controller;

use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Form\LivreurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livreur")
 */
class AcceuilLivreurController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(): Response
    {
        $livreur = $this->getUser()->getLivreur();
        return $this->render('acceuil_livreur/accueil.html.twig', [
            'controller_name' => 'AccueilAdminController',
            'livreur' => $livreur
        ]);
    }

    /**
     * @Route("/commande", name="livreur_commande")
     */
    public function commande(): Response
    {
        $user = $this->getUser()->getLivreur()->getId();
        $repo = $this->getDoctrine()->getRepository(Livraison::class);
        $livraison = $repo->findBy(['livreur' => $user, 'status' => 'Prise en charge livreur']);

        return $this->render('acceuil_livreur/index.html.twig', [
            'controller_name' => 'AcceuilLivreurController',
            'livraisons' => $livraison
        ]);
    }

    /**
     * @Route("/validation/{id}", name="validation_commande")
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

    /**
     * @Route("/{id}/edit", name="edit_livreur", methods={"GET","POST"})
     */
    public function edit(Request $request, Livreur $livreur): Response
    {
        $form = $this->createForm(LivreurType::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('accueil');
        }
        return $this->render('acceuil_livreur/edit.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView(),
        ]);
    }
}
