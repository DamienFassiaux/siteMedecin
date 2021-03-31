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
use App\Repository\AvisRepository;
use App\Entity\Avis;
use App\Repository\UtilisateursRepository;
use App\Entity\Utilisateurs;
use App\Form\EditUserType;
use App\Form\AvisType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;

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
     * @Route("/admin/{id}/edit-medecin", name="admin_edit_medecin")
     */
    public function adminEditMedecin(Medecins $medecin, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $medecin->setImage(
            new File($this->getParameter('image_directory').'/' .$medecin->getImage())
        );
     
        $formMedecin = $this->createForm(EditMedecinType::class, $medecin);

        dump($request);

        $formMedecin->handleRequest($request); 

        if($formMedecin->isSubmitted() && $formMedecin->isValid())
        {   
               dump($medecin);

             /** @var UploadedFile $imageFile */
             $imageFile = $formMedecin->get('image')->getData();
             dump($imageFile);

             if($imageFile)
             {
                 $originalFilename = pathinfo($imageFile->getClientOriginalname(), PATHINFO_FILENAME);
                 dump($originalFilename);

                 $safeFilename = $slugger->slug($originalFilename);
               dump($safeFilename);

               $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

               try
               {
                   $imageFile->move(
                       $this->getParameter('image_directory'),
                       $newFilename
                   );
               }
               catch(FileException $e)
               {

               }

               $medecin->setImage($newFilename);
             }

            if(!$medecin->getId())
                {
                $medecin->setNom;
                } 
            $manager->persist($medecin);
            $manager->flush();

            $this->addFlash('success', "Le médecin n° ". $medecin->getId() . " a bien été modifié");

            return $this->redirectToRoute('admin_medecins');

        }

        return $this->render('admin/admin_edit_medecin.html.twig', [
            'formEditMedecin'=> $formMedecin->createView(),
            'idMedecin'=> $medecin->getId()
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

            return $this->redirectToRoute('admin_departements');
        }

        return $this->render('admin/admin_edit_departement.html.twig', [
            'formDepartement'=> $formDepartement->createView(),
            'Departement' => $departement->getNumero()

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
            'formSpecialite'=> $formSpecialite->createView(),
            'Specialite' => $specialite->getNom()
        ]);
    } 


    /**
     * @Route("/admin/avis", name="admin_avis")
     * @Route("/admin/avis/{id}/remove", name="admin_remove_avis")
     */
    public function adminAvis(EntityManagerInterface $manager, AvisRepository $repoAvis, Avis $avis = null): Response
    {
       $colonnes = $manager->getClassMetaData(Avis::class)->getFieldNames();

       dump($colonnes);

       $avisRepo = $repoAvis->findAll();

        dump($avis);

        if($avis)
        {
            $id = $avis->getId();
            $auteur = $avis->getAuteur();

            $date = $avis->getCreatedAt();
            $dateFormat = $date->format('d/m/Y à H:i:s');

            $manager->remove($avis);
            $manager->flush();

            $this->addFlash('success', "L'avis n°$id posté par $auteur le $dateFormat a bien été supprimé !");

            return $this->redirectToRoute('admin_avis');
        }

        return $this->render('admin/admin_avis.html.twig', [
            'colonnes'=> $colonnes, 
            'avisBdd'=>$avisRepo 
        ]);

    }


    /**
     * @Route("/admin/avis/{id}/edit", name="admin_edit_avis")
     */
    public function editAvis(Avis $avis, Request $request, EntityManagerInterface $manager)
    {
        dump($avis);

        $formAvis = $this->createForm(AvisType::class, $avis);

        dump($request);

        $formAvis->handleRequest($request); 

        if($formAvis->isSubmitted() && $formAvis->isValid())
        {

            $id = $avis->getId();
            $auteur = $avis->getAuteur();
            $date = $avis->getCreatedAt();
            $dateFormat = $date->format('d/m/Y à H:i:s');

            $manager->persist($avis);
            $manager->flush();

            $this->addFlash('success', "L'avis n°$id posté par $auteur le $dateFormat a bien été modifié");

            return $this->redirectToRoute('admin_avis');

        }

        return $this->render('admin/admin_edit_avis.html.twig', [
            'idAvis'=> $avis->getId(),
            'formAvis'=> $formAvis->createView()
        ]);
    }


        /**
     * @Route("/admin/users", name="admin_users")
     * @Route("/admin/user/{id}/remove", name="admin_remove_user")
     */
    public function adminUsers(EntityManagerInterface $manager, UtilisateursRepository $repoUtilisateur, Utilisateurs $utilisateur = null): Response 
    {
        
    $colonnes = $manager->getClassMetadata(Utilisateurs::class)->getFieldNames();

        dump($colonnes);


        $utilisateurs = $repoUtilisateur->findAll();

        dump($utilisateur);

        if($utilisateur)
        {

            $id = $utilisateur->getId();

            $manager->remove($utilisateur);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur n°$id a bien été supprimé !");

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/admin_users.html.twig', [
            'colonnes'=> $colonnes,
            'utilisateursBdd'=>$utilisateurs 
        ]);
}

/**
     * 
     * @Route("/admin/user/{id}/edit", name="admin_edit_user")
     */
    public function adminEditUser(Utilisateurs $utilisateur, Request $request, EntityManagerInterface $manager): Response
    {
        dump($utilisateur);

        $formInscription = $this->createForm(EditUserType::class, $utilisateur);

        dump($request);

        $formInscription->handleRequest($request); 

        if($formInscription->isSubmitted() && $formInscription->isValid())
        {

            $id = $utilisateur->getId();
            $username = $utilisateur->getNom();

            $manager->persist($utilisateur);
            $manager->flush();

            $this->addFlash('success', "L'utilisateur $username ID$id a bien été modifié");

            return $this->redirectToRoute('admin_users');

        }

        return $this->render('admin/admin_edit_user.html.twig', [
            'idUtilisateur'=> $utilisateur->getId(),
            'formInscription'=> $formInscription->createView()
        ]);
    }

}
