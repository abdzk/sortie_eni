<?php

namespace App\Form;

use App\Entity\Campus;

use App\Entity\Lieu;
use App\Entity\Sortie;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('dateHeureDebut',DateTimeType::class,['widget'=>'single_text'])
            ->add('duree',IntegerType::class)
            ->add('dateLimiteInscription',DateTimeType::class,['widget'=>'single_text'])
            ->add('nbInscriptionsMax',IntegerType::class)
            ->add('infosSortie',TextareaType::class,['required'=> false])
            ->add('campus',EntityType::class, ['class'=>Campus::class,'choice_label'=>'nom'])
            ->add('lieu',EntityType::class,['class'=>Lieu::class,'choice_label'=>'nom','placeholder'=>'selectionnez votre lieu'])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
