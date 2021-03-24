<?php

namespace App\Controller;

use App\Entity\Medecins;
use App\Entity\Departement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MedecinsRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EditMedecinType;
use App\Form\DepartementType;
use App\Form\SpecialiteType;
use App\Repository\DepartementRepository;
use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    

     /**
     * @Route("/admin/medecins", name="admin_medecins")
     * @Route("/admin/{id}/remove", name="admin_remove_medecin")
     */
    public function adminMedecins(EntityManagerInterface $manager, MedecinsRepository $repoMedecins, Medecins $medecin = null): Response
    {
    
        $colonnes = $manager->getClassMetadata(Medecins::class)->getFieldNames();

        dump($colonnes);

        
        $medecins = $repoMedecins->findAll();

        dump($medecins);

        if($medecin)
        {

            $id = $medecin->getId();

            $manager->remove($medecin);
            $manager->flush();

            $this->addFlash('success', "Le médecin n°$id a bien été supprimé !");

            return $this->redirectToRoute('admin_medecins');
        }

        return $this->render('admin/admin_medecins.html.twig', [
            'colonnes'=> $colonnes,
            'medecinsBdd'=>$medecins 
        ]);
    }
    

    /**
     * 
     * @Route("/admin/{id}/edit-medecin", name="admin_edit_medecin")
     */
    public function adminEditMedecin(Medecins $medecin, Request $request, EntityManagerInterface $manager): Response
    {
        dump($medecin);

        $formMedecin = $this->createForm(EditMedecinType::class, $medecin);

        dump($request);

        $formMedecin->handleRequest($request); 

        if($formMedecin->isSubmitted() && $formMedecin->isValid())
        {
            $manager->persist($medecin);
            $manager->flush();

            $this->addFlash('success', "Le médecin n° ". $medecin->getId() . " a bien été modifié");

            return $this->redirectToRoute('admin_medecins');

        }

        return $this->render('admin/admin_edit_medecin.html.twig', [
            'idMedecin'=> $medecin->getId(),
            'formEditMedecin'=> $formMedecin->createView()
        ]);
    }


    /**
     * 
     * @Route("/admin/departements", name="admin_departements")
     * @Route("/admin/departements/{id}/remove", name="admin_remove_departement")
     */
    public function adminDepartements(Departement $departement = null, Request $request, EntityManagerInterface $manager, DepartementRepository $repoDepartement): Response
    {
        $colonnes = $manager->getClassMetadata(Departement::class)->getFieldNames();

        dump($colonnes);

      

        if($departement)
        {

            if($departement->getMedecins()->isEmpty()) 
            {
                $manager->remove($departement);
                $manager->flush();

                $this->addFlash('success', "Le département a bien été supprimé !");

            }
            else
            {
                $this->addFlash('danger', "Il n'est pas possible de supprimer le département car des médecins y sont associés !");
            }
                  
                 return $this->redirectToRoute('admin_departements');
        }

        $departements = $repoDepartement->findAll();

        dump($departements);

        return $this->render('admin/admin_departements.html.twig', [
             'colonnes'=>$colonnes,
             'departementsBdd'=>$departements
        ]);
    }


    /**
     * @Route("/admin/departement/new", name="admin_new_departement")
     * @Route("/admin/{id}/edit-departement", name="admin_edit_departement")
     */
    public function adminEditDepartement( Request $request, EntityManagerInterface $manager, Departement $departement = null): Response
    {

        if(!$departement)
         {
            $departement = new Departement;
         }
    

        $formDepartement = $this->createForm(DepartementType::class, $departement);

        dump($request);

        $formDepartement->handleRequest($request); 

        dump($departement);

        if($formDepartement->isSubmitted() && $formDepartement->isValid() )
        {
            if(!$departement->getId())
            {
                $message = "Le département " . $departement->getNom() . " a été enregistrée avec succès !";
            }
            else
            {
                $message = "Le département " . $departement->getNom() . " a été modifiée avec succès !";
            }
            $manager->persist($departement);
            $manager->flush();

            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/admin_edit_departement.html.twig', [
            'formDepartement'=> $formDepartement->createView()
        ]);
    } 


    /**
     * 
     * @Route("/admin/specialites", name="admin_specialites")
     * @Route("/admin/specialites/{id}/remove", name="admin_remove_specialite")
     */
    public function adminSpecialites(Specialite $specialite = null, Request $request, EntityManagerInterface $manager, SpecialiteRepository $repoSpecialite): Response
    {
        $colonnes = $manager->getClassMetadata(Specialite::class)->getFieldNames();

        dump($colonnes);

      

        if($specialite)
        {

            if($specialite->getMedecins()->isEmpty()) 
            {
                $manager->remove($specialite);
                $manager->flush();

                $this->addFlash('success', "La spécialité a bien été supprimé !");

            }
            else
            {
                $this->addFlash('danger', "Il n'est pas possible de supprimer la spécialité car des médecins y sont associés !");
            }
                  
                 return $this->redirectToRoute('admin_specialites');
        }

        $specialites = $repoSpecialite->findAll();

        dump($specialites);

        return $this->render('admin/admin_specialites.html.twig', [
             'colonnes'=>$colonnes,
             'specialitesBdd'=>$specialites
        ]);
    }


     /**
     * @Route("/admin/specialite/new", name="admin_new_specialite")
     * @Route("/admin/{id}/edit-specialite", name="admin_edit_specialite")
     */
    public function adminEditSpecialite( Request $request, EntityManagerInterface $manager, Specialite $specialite = null): Response
    {

        if(!$specialite)
         {
            $specialite = new Specialite;
         }
    

        $formSpecialite = $this->createForm(SpecialiteType::class, $specialite);

        dump($request);

        $formSpecialite->handleRequest($request); 

        dump($specialite);

        if($formSpecialite->isSubmitted() && $formSpecialite->isValid() )
        {
            if(!$specialite->getId())
            {
                $message = "La spécialité " . $specialite->getNom() . " a été enregistrée avec succès !";
            }
            else
            {
                $message = "La spécialité " . $specialite->getNom() . " a été modifiée avec succès !";
            }
            $manager->persist($specialite);
            $manager->flush();

            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_specialites');
        }

        return $this->render('admin/admin_edit_specialite.html.twig', [
            'formSpecialite'=> $formSpecialite->createView()
        ]);
    } 


}
