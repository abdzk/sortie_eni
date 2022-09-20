<?php

namespace App\Form;


use App\Entity\Campus;
use App\Models\Filtres;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;




class FiltresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus',EntityType::class, ['class'=>Campus::class,'choice_label'=>'nom'])
            ->add('nom',SearchType::class,['label'=>'Le nom de la sortie contient :'])
            ->add('dateDebut',DateType::class,['label'=> 'Entre','widget'=>'single_text'])
            ->add('dateFin',DateType::class,['label'=> 'Et','widget'=>'single_text'])
            ->add('sortiesOrganisateur',CheckboxType::class, [
                'label'    => 'Sorties dont je suis l"organisateur/trice',
                'required' => false,
            ])
            ->add('sortiesInscrit',CheckboxType::class,[
                'label'    => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('sortiesNonInscrit',CheckboxType::class,[
            'label'    => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sortiesPassees',CheckboxType::class,[
                'label'    => 'Sorties passées',
                'required' => false,
            ]);



    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filtres::class,
        ]);
    }

}