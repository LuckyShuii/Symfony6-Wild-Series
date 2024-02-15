<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function __construct(private SeasonRepository $seasonRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $seasons = $this->seasonRepository->findAll();

        $builder
            ->add('title', null, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre de l\'épisode',
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('number', null, [
                'label' => 'Numéro',
                'attr' => [
                    'placeholder' => 'Numéro de l\'épisode',
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('synopsis', null, [
                'label' => 'Résumé',
                'attr' => [
                    'placeholder' => 'Résumé de l\'épisode',
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('season', EntityType::class, [
                'class' => Season::class,
                'choices' => $seasons,
                'choice_label' => function (Season $season) {
                    return $season->getProgram()->getTitle() . ' - Saison ' . $season->getNumber();
                },
                'label' => 'Saison',
                'attr' => [
                    'class' => 'form-select mb-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class
        ]);
    }
}
