<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\ProfilType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ProfilUserController extends AbstractController
{


    /**
     *   @Route("/profil", name="main_profil")
     */

    public function modificationProfil(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();
    $form = $this->createForm(ProfilType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user=$form->getData();
        $entityManager->persist($user);
        $entityManager->flush();



 $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'Profil modifié avec succès.');
        return $this->redirectToRoute('main_accueil',['id'=>$user->getId()]);
    }

    return $this->render('main/profil.html.twig', [
        'ProfilType' => $form->createView(),
    ]);

}
}