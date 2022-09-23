<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{

    #[Route('/sortie', name: 'sortie_creation')]

    public function sortie(Request $request,EntityManagerInterface $entityManager):Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm ->handleRequest($request);

        if($sortieForm->isSubmitted() && $sortieForm->isValid())
        {
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('main_accueil');

        }


        return $this->render('sortie/creation.html.twig',
            ['sortieForm'=>$sortieForm->createView()]);

    }

    #[Route('/inscription/{id}', name: 'inscription')]
    public function inscription(int $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
    {



        $incriptionSortie = $sortieRepository->find($id);
        if(count($incriptionSortie->getUsers())< $incriptionSortie->getNbInscriptionsMax()){
            /**
             * @var User $user
             */
            $user = $this->getUser();
        }



        $incriptionSortie->addUser($user);



        $entityManager->persist($incriptionSortie);
        $entityManager->flush();



        $this->addFlash('success', "Vous êtes inscrit a la sortie");
        return $this->redirectToRoute('main_accueil');
    }

    #[Route('/desinscription/{id}', name: 'desinscription')]
    public function desinscription (int $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
    {
        $desinscription = $sortieRepository->find($id);

             /**
             * @var User $user
             */
            $user = $this->getUser();
            $desinscription->removeUser($user);



        $entityManager->persist($desinscription);
        $entityManager->flush();
        $this->addFlash('success', "Votre desinscription est prise en compte");
        return $this->redirectToRoute('main_accueil');
    }


    #[Route('sortie/afficher/{id}', name: 'sortie_afficher')]
    public function afficher(int $id,SortieRepository $sortieRepository)
    {

        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/afficher.html.twig',[
            "sortie"=>$sortie
        ]);
    }


}