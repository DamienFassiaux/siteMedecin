<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateurs;
use App\Form\InscriptionType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function formInscription(): Response
    {   
        $utilisateur = new Utilisateurs;

        $form = $this->createForm(InscriptionType::class, $utilisateur);

        return $this->render('security/inscription.html.twig', [
           'formInscription' => $form ->createView()
        ]);
    }
}
