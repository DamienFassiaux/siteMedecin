<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Medecins;
use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\MedecinsRepository;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'Bienvenue',
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

          if($formAvis->isSubmitted() && $formAvis->isValid())
          {
              $avis->setCreatedAt(new \DateTime())
                       ->setMedecins($medecin);
 
                       $manager->persist($avis);
                       $manager->flush();
 
                       $this->addFlash('success', "L'avis a bien été posté!");
 
                       return $this->redirectToRoute('site_medecins', [
                                 'id' => $medecin->getId() 
                       ]);
          }
 
          return $this->render('site/cardMedecin.html.twig',[
                     'medecin'=> $medecin,
                     'formAvis' => $formAvis->createView()     
 
          ]);


    }
}
