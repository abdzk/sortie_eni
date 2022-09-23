<?php

namespace App\Controller;


use App\Form\FiltresType;

use App\Models\Filtres;
use App\Repository\SortieRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/accueil', name: 'main_accueil')]
    public function affichageSorties(SortieRepository $sortieRepository,Request $request,EntityManagerInterface $entityManager): Response
    {
         $filtre = new Filtres();
        $filtreForm = $this->createForm(FiltresType::class,$filtre);
        $filtreForm->handleRequest($request);



        //récupère toutes les sorties
        $sorties = $sortieRepository->listeSortie($filtre,$this->getUser());
        //afficher une erreur si n'existe pas dans la bdd

        //envoyer vers twig
        return $this->render('main/acceuil.html.twig', [
            "sorties" => $sorties,
            'filtreForm'=>$filtreForm->createView()

        ]);
    }
}
