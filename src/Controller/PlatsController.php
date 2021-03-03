<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\Plats1Type;
use App\Repository\PlatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @param SluggerInterface $slugger
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $plat = new Plats();
        $form = $this->createForm(Plats1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('plat_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $newFilename = 'plat-default.jpg';
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $plat->setImageFilePlat($newFilename);
            }
            else
            {
                $plat->setImageFilePlat('plat-default.jpg');
            }
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
     * @param SluggerInterface $slugger
     */
    public function edit(Request $request, Plats $plat, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Plats1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plats_index');
        }

        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
            try {
                $imageFile->move(
                    $this->getParameter('plat_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $newFilename = 'plat-default.jpg';
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $plat->setImageFilePlat($newFilename);
        } else {
            $plat->setImageFilePlat('plat-default.jpg');
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
        if ($this->isCsrfTokenValid('delete' . $plat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plats_index');
    }

}
