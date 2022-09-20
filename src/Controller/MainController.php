<?php

namespace App\Controller;


use App\Form\FiltresType;
use App\Form\SortieType;
use App\Models\Filtres;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route ("/accueil",name="main_accueil")
     */
    public function affichageSorties(SortieRepository $sortieRepository,Request $request,): Response
    {

        $filtreForm = $this->createForm(FiltresType::class);
        $filtreForm->handleRequest($request);

        //récupère toutes les sorties
        $sorties = $sortieRepository->findAll();
        //afficher une erreur si n'existe pas dans la bdd
        if (!$sorties)
        {
            throw $this->createNotFoundException("Cette sortie n'existe pas !");
        }
        //envoyer vers twig
        return $this->render('main/acceuil.html.twig', [
            "sorties" => $sorties,
            'filtreForm'=>$filtreForm->createView()

        ]);
    }
}
