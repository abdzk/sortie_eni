<?php

namespace App\Form;


use App\Entity\Campus;
use App\Models\Filtres;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;




class FiltresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus',EntityType::class, ['class'=>Campus::class,'choice_label'=>'nom'])
            ->add('nom')
            ->add('dateDebut',DateType::class)
            ->add('dateFin',DateType::class)
            ->add('sortiesOrganisateur',CheckboxType::class)
            ->add('sortiesInscrit',CheckboxType::class)
            ->add('sortiesNonInscrit',CheckboxType::class)
            ->add('sortiesPassees',CheckboxType::class);



    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filtres::class,
        ]);
    }

}