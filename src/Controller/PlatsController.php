<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\Plats1Type;
use App\Repository\PlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/restaurateur/plats")
 */
class PlatsController extends AbstractController
{
    /**
     * @Route("/", name="plats_index", methods={"GET"})
     */
    public function index(PlatsRepository $platsRepository): Response
    {
        $restaurant = $this->getUser()->getRestaurant()->getId();

        return $this->render('plats/index.html.twig', [
            'plats' => $platsRepository->findBy(['restaurant' => $restaurant])
        ]);
    }

    /**
     * @Route("/new", name="plats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plat = new Plats();
        $form = $this->createForm(Plats1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $restaurant = $this->getUser()->getRestaurant();
            $plat->setRestaurant($restaurant);
            $entityManager->persist($plat);
            $entityManager->flush();

            return $this->redirectToRoute('plats_index');
        }

        return $this->render('plats/new.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plats_show", methods={"GET"})
     */
    public function show(Plats $plat): Response
    {
        return $this->render('plats/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plats $plat): Response
    {
        $form = $this->createForm(Plats1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plats_index');
        }

        return $this->render('plats/edit.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plats_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plats $plat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plats_index');
    }
}
