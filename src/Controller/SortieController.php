<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\SortieType;

use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SortieController extends AbstractController
{
    /**
     * @Route ("/sortie",name="sortie_creation")
     */
    public function sortie(Request $request,EntityManagerInterface $entityManager,SortieRepository $sortieRepository,EtatRepository $etatRepository):Response
    {

        $etats = $etatRepository->findAll();
        $user=$this->getUser();
        $sortie = new Sortie();
        $sortie->setOrganisateur($user);
        $sortie->setCampus($user->getCampus());
        $sortie->setEtat($etats[3]);



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
    /**
     * @Route("/inscription/{id}", name="inscription")
     */
    public function inscription(int $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
    {



        $incriptionSortie = $sortieRepository->find($id);
        if(count($incriptionSortie->getUsers())< $incriptionSortie->getNbInscriptionsMax()){
            $user = $this->getUser();
        }



        $incriptionSortie->addUser($user);



        $entityManager->persist($incriptionSortie);
        $entityManager->flush();



        $this->addFlash('success', "Vous êtes inscrit a la sortie");
        return $this->redirectToRoute('main_accueil');
    }
    /**
     * @Route("/desinscription/{id}", name="desinscription")
     */
    public function desinscription (int $id, SortieRepository $sortieRepository, EntityManagerInterface $entityManager): Response
    {
        $desinscription = $sortieRepository->find($id);



        if ($desinscription->getDateLimiteInscription() >= new \DateTime('now')){
            $user = $this->getUser();
            $desinscription->removeUser($user);
        }


        $entityManager->persist($desinscription);
        $entityManager->flush();
        $this->addFlash('success', "Votre desinscription est prise en compte");
        return $this->redirectToRoute('main_accueil');
    }



    private function isSubmitted()
    {
    }

    private function isValid()
    {
    }

    private function getEtat()
    {
    }
}