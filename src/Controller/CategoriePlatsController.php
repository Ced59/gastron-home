<?php

namespace App\Controller;

use App\Entity\CategoriePlats;
use App\Form\CategoriePlatsType;
use App\Repository\CategoriePlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie/plats")
 */
class CategoriePlatsController extends AbstractController
{
    /**
     * @Route("/", name="categorie_plats_index", methods={"GET"})
     */
    public function index(CategoriePlatsRepository $categoriePlatsRepository): Response
    {
        return $this->render('categorie_plats/index.html.twig', [
            'categorie_plats' => $categoriePlatsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_plats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoriePlat = new CategoriePlats();
        $form = $this->createForm(CategoriePlatsType::class, $categoriePlat);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoriePlat);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_plats_index');
        }

        return $this->render('categorie_plats/new.html.twig', [
            'categorie_plat' => $categoriePlat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_plats_show", methods={"GET"})
     */
    public function show(CategoriePlats $categoriePlat): Response
    {
        return $this->render('categorie_plats/show.html.twig', [
            'categorie_plat' => $categoriePlat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_plats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoriePlats $categoriePlat): Response
    {
        $form = $this->createForm(CategoriePlatsType::class, $categoriePlat);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_plats_index');
        }

        return $this->render('categorie_plats/edit.html.twig', [
            'categorie_plat' => $categoriePlat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_plats_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoriePlats $categoriePlat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoriePlat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoriePlat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_plats_index');
    }
}
