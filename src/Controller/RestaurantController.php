<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="edit_restaurant", methods={"GET","POST"})
     * @param Request $request
     * @param Restaurant $restaurant
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function edit(Request $request, Restaurant $restaurant, SluggerInterface $slugger): Response
    {

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imageResto')->getData();

            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('restaurant_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $newFilename = 'restaurant-default.jpg';
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $restaurant->setImageFileRestaurant($newFilename);
            }
            else
            {
                $restaurant->setImageFileRestaurant('restaurant-default.jpg');
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('restaurant');

        }
        return $this->render('restaurant/index.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }
}
