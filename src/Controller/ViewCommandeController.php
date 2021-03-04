<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandePlat;
use App\Entity\Livraison;
use App\Entity\Livreur;
use App\Entity\Plats;
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
        $commandes = $repo->findBy(['restaurant' => $user, "status" => "Attente"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'en attente'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-acceptees", name="view_commandes_acceptee")
     */
    public function viewCommandAcceptee(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant' => $user, "status" => "Acceptée"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'acceptées'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-pretes", name="view_commandes_pretes")
     */
    public function viewCommandPrete(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant' => $user, "status" => "Prête"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'prêtes'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-prise-en-charge", name="view_commandes_pec")
     */
    public function viewCommandPec(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant' => $user, "status" => "Prise en charge"]);
        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'prises en charges'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-livree", name="view_commandes_livree")
     */
    public function viewCommandLivrees(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant' => $user, "status" => "Livré"]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'livrées'
        ]);
    }

    /**
     * @Route("/restaurant/commandes-totales", name="view_commandes_totales")
     */
    public function viewCommandTotales(): Response
    {
        $user = $this->getUser()->getRestaurant()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['restaurant' => $user]);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'les commandes'
        ]);
    }

    /**
     * @Route("/client/commandes", name="view_commandes_client")
     */
    public function viewCommandClient(): Response
    {
        $user = $this->getUser()->getId();
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $repo->findBy(['utilisateur' => $user], ['id' => 'DESC']);

        return $this->render('view_commande/index.html.twig', [
            'commandes' => $commandes,
            'title' => 'Voir les commandes'
        ]);
    }

    /**
     * @Route("/view/commande/{id}", name="show_commande")
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repository->find($id);
        $plats = $commande->getCommandePlats();

        $idSecteur = $this->getUser()->getVille()->getSecteur()->getId();

        $repoLivreur = $this->getDoctrine()->getRepository(Livreur::class);
        $livreurs = $repoLivreur->findByDispoAndSecteur($idSecteur);

        if (!empty($livreurs)){
            $idLivreur = array_rand($livreurs);
            $livreur = $livreurs[$idLivreur];
        } else {
            $livreur = [];
        }

        return $this->render('view_commande/show-commande.html.twig', [
            'livreurs' => $livreur,
            'commande' => $commande,
            'plats' => $plats,
            'title' => 'Détail de la commande'
        ]);
    }

    /**
     * @Route("/restaurant/commandes/{id}/accept", name="accept_command")
     */
    public function acceptCommand(int $id): Response
    {
        $repoCommand = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repoCommand->find($id);

        $idCommand = $commande->getId();

        $commande->setStatus('Acceptée');

        $repoCommandPlat = $this->getDoctrine()->getRepository(CommandePlat::class);
        $commandPlat = $repoCommandPlat->findBy(['commande' => $idCommand]);
        $plats = [];

        foreach ($commandPlat as $item) {
            $plats[] = [
                'plat' => $item->getPlats(),
                'quantity' => $item->getQuantite()
            ];
        }

        $repoPlat = $this->getDoctrine()->getRepository(Plats::class);
        foreach ($plats as $plate) {
            $quantite = $plate['quantity'];
            $plat = $repoPlat->find($plate['plat']->getId());
            $qte = $plat->getQte();
            $qte -= $quantite;
            $plat->setQte($qte);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plat);
            $entityManager->flush();
        }


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();

        $adresseLivraison = $commande->getUtilisateur()->getAdress();
        $cpLivraison = $commande->getUtilisateur()->getVille()->getCodePostal();
        $villeLivraison = $commande->getUtilisateur()->getVille();

        $finalAdress = $adresseLivraison . " " . $cpLivraison . " " . $villeLivraison;

        $idSecteur = $this->getUser()->getVille()->getSecteur()->getId();

        $repoLivreur = $this->getDoctrine()->getRepository(Livreur::class);
        $livreurs = $repoLivreur->findByDispoAndSecteur($idSecteur);

        $idLivreur = array_rand($livreurs);

        $livreurs[$idLivreur]->setIsDisponible(false);

        $livraison = new Livraison();
        $livraison->setStatus("Acceptée");
        $livraison->setCommande($commande);
        $livraison->setLivreur($livreurs[$idLivreur]);
        $livraison->setAdresseLivraison($finalAdress);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livraison);
        $entityManager->flush();

        return $this->redirectToRoute('view_commandes_attente');
    }

    /**
     * @Route("/restaurant/commandes/{id}/ready", name="ready_command")
     */
    public function readyCommand(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);
        $commande = $repo->find($id);

        $commande->setStatus('Prête');


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();

        $idLivraison = $commande->getLivraison()->getId();
        $repoLivraison = $this->getDoctrine()->getRepository(Livraison::class);
        $livraison = $repoLivraison->find($idLivraison);
        $livraison->setStatus("Prête");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($livraison);
        $entityManager->flush();


        return $this->redirectToRoute('view_commandes_acceptee');
    }

}
