<?php

namespace App\Controller;

use App\Repository\PlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     * @param SessionInterface $session
     * @param PlatsRepository $platsRepository
     * @return Response
     */
    public function index(SessionInterface $session, PlatsRepository $platsRepository): Response
    {
        $panier = $session->get('panier', []);

        $panierData = [];

        foreach ($panier as $id => $quantity){
            $panierData[]=[
                'plat' => $platsRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0 ;
        $fraisLivraisons = 3;
        foreach ($panierData as $item){
            $totalItem = $item['plat']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        $sousTotal = $total;

        $total += $fraisLivraisons;

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items' => $panierData,
            'total' => $total,
            'sousTotal' => $sousTotal,
            'fraisLivraisons' => $fraisLivraisons
        ]);
    }

    /**
     * @Route("/panier/add/{idRestaurant}/{id}", name="panier_add")
     * @param int $id
     * @param int $idRestaurant
     * @param SessionInterface $session
     * @return Response
     */
    public function add(int $id, int $idRestaurant, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('restaurant_menu', ['id'=>$idRestaurant]);
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     * @param int $id
     * @param SessionInterface $session
     * @return Response
     */
    public function remove(int $id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])){
            $panier[$id]--;
        }
        if($panier[$id] == 0){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }
}
