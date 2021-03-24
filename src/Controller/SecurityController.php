<?php

namespace App\Controller;

use App\Entity\Medecins;
use App\Entity\Utilisateurs;
use App\Form\InscriptionType;
use App\Form\MedecinInscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function formInscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {

        $utilisateur = new Utilisateurs;

        $form = $this->createForm(InscriptionType::class, $utilisateur);
        $form->handleRequest($request);
        dump($request);
        dump($utilisateur);


        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($hash);
            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', "félicitations !! Votre compte a bien été validé ! vous pouvez dès à présent vous connecter");
            return $this->redirectToRoute('site');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());

            $utilisateur->setPassword($hash);

            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', "félicitations !! Votre compte a bien été validé ! vous pouvez dès à présent vous connecter");
            return $this->redirectToRoute('security_login');
        }


        return $this->render('security/inscription.html.twig', [
            'formInscription' => $form->createView()
        ]);
    }

    /**
     * @Route("/medecin/inscription", name="medecin_inscription")
     */
    public function formMedecinInscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        $medecin = new Medecins;

        $form = $this->createForm(MedecinInscriptionType::class, $medecin);
        $form->handleRequest($request);
        dump($request);
        dump($medecin);


        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($medecin, $medecin->getPassword());

            $medecin->setPassword($hash);
            $manager->persist($medecin);
            $manager->flush();

            $this->addFlash('success', "félicitations !! Votre compte a bien été validé ! vous pouvez dès à présent vous connecter");
            return $this->redirectToRoute('site');
        }

        return $this->render('security/medecininscription.html.twig', [
            'formMedecinInscription' => $form->createView()
        ]);
    }

    /**
     * AuthenticationUtils permet de récupérer le dernier email saisi au moment de la connexion
     * AuthenticationUtils pemet de récuperer le message d erreur en cas de mauvaise connexion
     * 
     * @Route("/connexion" , name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */

    public function logout()
    {
    }

    /**
     * 
     * @Route("/medecin/connexion" , name="medecin_login")
     */
    public function loginMedecin(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginmedecin.html.twig', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }
}
