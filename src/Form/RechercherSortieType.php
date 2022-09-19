<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercherSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('campus',EntityType::class, ['class'=>Campus::class,'choice_label'=>'nom'])
            ->add('Le_nom_de_la_sortie_contient',EntityType::class,['class' =>Sortie::class,'choice_label'=>'nom'])
            ->add('Entre', \Symfony\Component\Form\Extension\Core\Type\DateType::class)
            ->add('Et', \Symfony\Component\Form\Extension\Core\Type\DateType::class)
            ->add('sortieOrganisateur', CheckboxType::class, [
                'label'    => 'Sorties dont je suis l"organisateur/trice',
                'required' => false,
            ])
            ->add('sortieParticipant', CheckboxType::class, ['class'=>User::class,
                'label'    => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('sortieNonParticipant', CheckboxType::class, ['class'=>User::class,
                'label'    => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sortiesPassees', CheckboxType::class, ['class'=>User::class,
                'label'    => 'Sortie passées',
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campus::class,
        ]);
    }
}
