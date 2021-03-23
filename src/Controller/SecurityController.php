<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateurs;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function formInscription(Request $request, EntityManagerInterface $manager): Response
    {   
        $utilisateur = new Utilisateurs;

        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $manager->persist($utilisateur); 
                $manager->flush(); 

                $this->addFlash('success', "félicitations !! Votre compte a bien été validé ! vous pouvez dès à présent vous connecter");
                return $this->redirectToRoute('site');
            }


        return $this->render('security/inscription.html.twig', [
           'formInscription' => $form ->createView()
        ]);
    }
}
