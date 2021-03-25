<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Medecins;
use App\Form\RdvFormType;
use App\Entity\Utilisateurs;
use App\Form\InscriptionType;
use App\Repository\MedecinsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'Bienvenue',
        ]);
    }

    /**
     * @Route("/site", name="site")
     */
    public function index(MedecinsRepository $repo): Response
    {

        dump($repo); 

        $medecins = $repo->findAll(); 

        dump($medecins);

        return $this->render('site/index.html.twig', [
            'title' => 'Liste des médecins',
            'medecins' => $medecins 
        ]);
    }

    /**
     * @Route("/site/rdv", name="prise_rdv")
     */
    public function rendezVous(Request $request, EntityManagerInterface $manager): Response
    {
        $rdv = new Rdv;
        $form = $this->createForm(RdvFormType::class, $rdv);
        $form->handleRequest($request);
        dump($request);
        dump($rdv);
        return $this->render('site/priserdv.html.twig', [
            'formRdv' => $form->createView()
        ]);
    }



    /**
     * @Route("/site/moncompte", name="compte_medecin")
     */
    public function medecinshow(request $request, EntityManagerInterface $manager): Response
    {
        $rdvMedecin = new Rdv();
        //$medecin = new Medecins;

        $medecinUser = $this->getUser();



        dump($rdvMedecin);
        dump($medecinUser);


        return $this->render('site/comptemedecin.html.twig', [
            'nom' => $medecinUser->getNom(),
            'prenom' => $medecinUser->getPrenom(),
            'adresse' => $medecinUser->getAdresse(),
            'ville' => $medecinUser->getVille(),
            'codePostale' => $medecinUser->getCodePostal(),
            'specialite' => $medecinUser->getSpecialite(),
            //'mesRdv' =>  $medecinUser->getRdvs()


        ]);
    }



    /**
     * 
     * @Route("/site/{id}", name="site_medecin")
     */
    public function show(Medecins $medecin, request $request, EntityManagerInterface $manager): Response
    {
        $avis = new Avis();

        $formAvis = $this->createForm(AvisType::class, $avis);

        $formAvis->handleRequest($request);

        $user = $this->getUser();


        dump($user);

        if ($formAvis->isSubmitted() && $formAvis->isValid()) {
            $avis->setCreatedAt(new \DateTime())
                ->setMedecins($medecin)
                ->setUtilisateurs($user);

            $manager->persist($avis);
            $manager->flush();

            $this->addFlash('success', "L'avis a bien été posté!");

            return $this->redirectToRoute('site_medecin', [
                'id' => $medecin->getId()
            ]);
        }

        return $this->render('site/cardMedecin.html.twig', [
            'medecin' => $medecin,
            'formAvis' => $formAvis->createView()

        ]);
    }
}
