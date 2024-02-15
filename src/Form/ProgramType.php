<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                null,
                [
                    'label' => 'Titre',
                    'attr' => [
                        'placeholder' => 'Titre de la série',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add(
                'synopsis',
                null,
                [
                    'label' => 'Synopsis',
                    'attr' => [
                        'placeholder' => 'Synopsis de la série',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add(
                'poster',
                null,
                [
                    'label' => 'Lien de l\'image',
                    'attr' => [
                        'placeholder' => 'https://www.exemple.com/image.jpg',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add(
                'country',
                null,
                [
                    'label' => 'Pays',
                    'attr' => [
                        'placeholder' => 'Espagne',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add(
                'year',
                null,
                [
                    'label' => 'Année de diffusion',
                    'attr' => [
                        'placeholder' => '2013',
                        'class' => 'form-control mb-3'
                    ]
                ]
            )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
