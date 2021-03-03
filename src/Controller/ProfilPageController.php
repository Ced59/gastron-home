<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfilPageController extends AbstractController
{
    /**
     * @Route("/utilisateur/profil", name="profil_page")
     */
    public function index(): Response
    {
        return $this->render('profil_page/index.html.twig', [
            'controller_name' => 'ProfilPageController',
        ]);
    }


    /**
     * @Route("/{id}/utilisateur/edit", name="profil_edit", methods={"GET","POST"})
     * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function edit(Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

       if ($form->isSubmitted()
           //&& $form->isValid()
           ) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('profil_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $newFilename = 'profil-default.jpg';
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImageFileName($newFilename);
            } else {
                $user->setImageFileName('profil-default.jpg');
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_page');
        }

        return $this->render('profil_page/edit.html.twig', [
            'user' => $user,
           'form' => $form->createView(),
        ]);
    }

}
