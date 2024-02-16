<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'John',
                    'class' => 'form-control mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un prénom'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'form-control mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom'
                    ])
                ]
            ])
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'johndoe23',
                    'class' => 'form-control mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom d\'utilisateur'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'mon@email.com',
                    'class' => 'form-control mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une adresse email'
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez acceptez les conditions',
                    ]),
                ],
                'label' => 'Accepter les conditions',
                'attr' => [
                    'class' => 'form-check-input mb-3'
                ]
            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => '******',
                    'class' => 'form-control mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
