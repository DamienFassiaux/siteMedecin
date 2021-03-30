<?php

namespace App\Controller;

use App\Entity\Medecins;
use App\Form\SearchType;
use App\Form\SearchFormType;
use App\Repository\MedecinsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{
    /**
     * @Route("site/search", name="search")
     */
    public function search(Request $request, MedecinsRepository $repoSearch): Response
    {

        $formSearch = $this->createForm(SearchFormType::class);


        $formSearch->handleRequest($request);
        //dd($request);
        $filtre = $formSearch->getData();



        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            //dd($filtre);
            //$medecin = $repoSearch->findByMedecin($filtre);
            $medecin = $repoSearch->findBy([
                'departement' => $filtre['departement']->getId(),
                'specialite' => $filtre['specialite']->getId()
            ]);
            return $this->render('search/result.html.twig', [
                'medecins' => $medecin,
                'formSearch' => $formSearch->createView()
            ]);
            //dd($medecin);
        }
        return $this->render('search/search.html.twig', [
            //'medecins' => $medecin,
            'formSearch' => $formSearch->createView()
        ]);
        // return $this->render('site/index.html.twig', [
        //     //'medecins' => $medecin,
        //     'formSearch' => $formSearch->createView()
        // ]);
    }
}
