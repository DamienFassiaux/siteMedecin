<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MedecinsRepository;
use App\Entity\Medecins;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;


class SearchController extends AbstractController
{
    /**
     * @Route("site/search", name="search")
     */
    public function search(Medecins $medecins = null, Request $request, EntityManagerInterface $manager, MedecinsRepository $repoSearch): Response
    {

        $formSearch = $this->createForm(SearchType::class, $medecins);


        $formSearch->handleRequest($request);

        //$medecin = $repoSearch->findBy(array('departement' => 'Yvelines'));
       $medecin = $repoSearch->findAll();

         dump($medecin);

         if($medecins)
         {
         $search = $medecins->getId();



        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
          
            $medecin = $repoSearch->findBy(array($search => 'nom'));
            

            $manager->persist($medecins);
            $manager->flush(); 

            return $this->redirectToRoute('search');
        }
        }
    
        return $this->render('search/search.html.twig',[
            'medecins'=> $medecin,
            'formSearch' => $formSearch->createView() 
        ]);
    
   }
}
