<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
/**
 * @Route ("/accueil",name="main_accueil")
 */
public function acceuil(){

return $this->render('main/acceuil.html.twig');
}
}