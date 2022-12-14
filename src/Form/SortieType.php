<?php

namespace App\Form;

use App\Entity\Campus;

use App\Entity\Lieu;
use App\Entity\Sortie;

use App\Entity\User;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['label'=>'Nom de la sortie'])
            ->add('dateHeureDebut',DateTimeType::class,['label'=>'Date et heure de la sortie','widget'=>'single_text'])
            ->add('dateLimiteInscription',DateTimeType::class,['label'=>'Date limite d\'incription','widget'=>'single_text'])
            ->add('nbInscriptionsMax',IntegerType::class,['label'=>'Nombre de places'])
            ->add('duree',NumberType::class)
            ->add('infosSortie',TextareaType::class,['label'=>'Description et infos','required'=> false])
            //     ->add('ville',EntityType::class,['class'=>Ville::class,'choice_label'=>'nom'])
            ->add('lieu',EntityType::class,['class'=>Lieu::class,'choice_label'=>'nom','placeholder'=>'Selectionnez votre lieu'])

            ->add('latitude',EntityType::class,['class'=>Lieu::class, 'Required'=> false ])
            ->add('longitude',EntityType::class,['class'=>Lieu::class, 'Required'=> false ])




        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
