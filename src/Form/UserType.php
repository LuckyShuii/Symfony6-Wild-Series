<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un nom d\'utilisateur',
                    ]),
                ]
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un prénom',
                    ]),
                ]
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un nom',
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un email',
                    ]),
                ]
            ])
            ->add('biography', null, [
                'label' => 'Biographie',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôles',
                'attr' => [
                    'class' => 'mb-4 d-flex align-items-center'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
