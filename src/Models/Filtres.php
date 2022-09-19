<?php

namespace App\Models;




use App\Entity\Campus;
use DateTime;


class Filtres{


    public ?Campus $campus = null;

    public ?string $nom = null;

    public ?DateTime $dateDebut = null;

    public ?DateTime $dateFin = null;

    public bool $sortiesOrganisateur = false;

    public  bool $sortiesInscrit = false;

    public  bool $sortiesNonInscrit = false;

    public  bool $sortiesPassees = false;

}