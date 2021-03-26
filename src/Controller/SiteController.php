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
    public function home(MedecinsRepository $repo): Response
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
     * @Route("/site/rdv/{id}", name="prise_rdv")
     */
    public function rendezVous(Medecins $medecin, Request $request, EntityManagerInterface $manager): Response
    {
        $rdv = new Rdv;
        $formRdv = $this->createForm(RdvFormType::class, $rdv);
        $formRdv->handleRequest($request);
        //dump($request);

        $user = $this->getUser();
        dump($user);
        dump($medecin);

        if ($formRdv->isSubmitted() && $formRdv->isValid()) {
            $rdv->setMedecins($medecin)
                ->setUtilisateurs($user);

            $manager->persist($rdv);
            $manager->flush();

            $this->addFlash('success', "Votre  rendez vous a bien été prsie en compte!");
        }
        return $this->render('site/priserdv.html.twig', [
            'formRdv' => $formRdv->createView(),
            'nomMedecin' => $medecin->getNom()
        ]);
    }



    /**
     * @Route("/site/moncompte", name="compte_medecin")
     * @Route("/site/moncompte/{id}/remove", name="doc_remove_rdv")
     * 
     */
    public function medecinshow(Rdv $rdvMedecin = null, Request $request, EntityManagerInterface $manager): Response
    {

        if ($rdvMedecin) {
            $manager->remove($rdvMedecin);
            $manager->flush();

            $this->addFlash('success', "Le rendez vous a bien été supprimé !");
        }

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
            'mesRdv' =>  $medecinUser->getRdvs()


        ]);
    }

    /**
     * @Route("/site/moncompte/{id}/edit-rdv", name="doc_edit_rdv")
     */
    public function docEditRdv(Request $request, EntityManagerInterface $manager, Rdv $rdv = null): Response
    {

        $formRdv = $this->createForm(RdvFormType::class, $rdv);


        dump($request);

        $formRdv->handleRequest($request);

        dump($rdv);

        if ($formRdv->isSubmitted() && $formRdv->isValid()) {


            $manager->persist($rdv);
            $manager->flush();

            $this->addFlash('success', "Le rendez vous a bien été modifié !");

            return $this->redirectToRoute('compte_medecin');
        }

        return $this->render('site/doc_edit_rdv.html.twig', [
            'formRdv' => $formRdv->createView(),

        ]);
    }



    /**
     * 
     * @Route("/site/{id}", name="site_medecin")
     * 
     */
    public function show(Medecins $medecin, request $request, EntityManagerInterface $manager): Response
    {
        $avis = new Avis();
        // $rdv = new Rdv();

        $formAvis = $this->createForm(AvisType::class, $avis);
        //$formRdv = $this->createForm(RdvFormType::class, $avis);

        $formAvis->handleRequest($request);
        // $formRdv->handleRequest($request);


        $user = $this->getUser();


        dump($user);
        dump($medecin);

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
        // if ($formRdv->isSubmitted() && $formRdv->isValid()) {

        //     $rdv->setMedecins($medecin)
        //         ->setUtilisateurs($user);

        //     $manager->persist($rdv);
        //     $manager->flush();

        //     $this->addFlash('success', "Le RDV  a bien été prsie en compte!");
        // }
        return $this->render('site/cardMedecin.html.twig', [
            'medecin' => $medecin,
            'formAvis' => $formAvis->createView()
            //'formRdv' => $formRdv->createView()

        ]);
    }
}
