<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'label' => 'Numéro',
                'attr' => [
                    'placeholder' => 'Numéro de la saison',
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add(
                'year',
                null,
                [
                    'label' => 'Année',
                    'attr' => [
                        'placeholder' => 'Année de la saison',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'Description',
                    'attr' => [
                        'placeholder' => 'Description de la saison',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add('program', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'title',
                'label' => 'Série',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Season::class,
        ]);
    }
}
