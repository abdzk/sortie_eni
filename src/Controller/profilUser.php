<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class profilUser extends AbstractController
{
    /**
     * @Route("/profil", name="main_profil")
     */
    public function profilUser ()
    {

        return $this->render('main/profil.html.twig');
    }
}