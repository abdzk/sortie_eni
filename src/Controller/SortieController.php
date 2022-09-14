<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
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
    public function sortie(Request $request,EntityManagerInterface $entityManager):Response
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm ->handleRequest($request);

        if($sortieForm> $this->isSubmitted() && $sortieForm> $this->isValid())
        {
            $entityManager->persist($sortie);
            $entityManager->flush();
        }


        return $this->render('sortie/creation.html.twig',['sortieForm'=>$sortieForm->createView()]);

    }

    private function isSubmitted()
    {
    }

    private function isValid()
    {
    }
}