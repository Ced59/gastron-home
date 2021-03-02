<?php

namespace App\Controller;

use App\Entity\CategorieRestaurant;
use App\Form\CategorieRestaurantType;
use App\Repository\CategorieRestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie/restaurant")
 */
class CategorieRestaurantController extends AbstractController
{
    /**
     * @Route("/", name="categorie_restaurant_index", methods={"GET"})
     */
    public function index(CategorieRestaurantRepository $categorieRestaurantRepository): Response
    {
        return $this->render('categorie_restaurant/index.html.twig', [
            'categorie_restaurants' => $categorieRestaurantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_restaurant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieRestaurant = new CategorieRestaurant();
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieRestaurant);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_restaurant_index');
        }

        return $this->render('categorie_restaurant/new.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_restaurant_show", methods={"GET"})
     */
    public function show(CategorieRestaurant $categorieRestaurant): Response
    {
        return $this->render('categorie_restaurant/show.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieRestaurant $categorieRestaurant): Response
    {
        $form = $this->createForm(CategorieRestaurantType::class, $categorieRestaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_restaurant_index');
        }

        return $this->render('categorie_restaurant/edit.html.twig', [
            'categorie_restaurant' => $categorieRestaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_restaurant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieRestaurant $categorieRestaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieRestaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieRestaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_restaurant_index');
    }
}
