<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType:: class, [
                'attr' => [
                    'class' => 'form-control'
                ],

                'label' => 'Nom',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
            
                'constraints' => [
                    new Assert\NotBlank()
                ]       
            ])

            ->add('prenom', TextType::class, [
                'attr' =>[
                    'class' => 'form-control'
                ],

                'label' => 'Prénom',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],

                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('adresse' , TextareaType::class, [
                'attr' =>[
                    'class' => 'form-control'
                ],

                'label' => 'Adresse',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
                
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('email' , EmailType::class , [
                'attr' =>[
                    'class' => 'form-control'
                ],

                'label' => 'E-mail',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
                
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email()
                ]
            ] )

            ->add('password', PasswordType::class, [
                'attr' =>[
                    'class' => 'form-control'
                ],

                'label' => 'Mot de passe',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
                
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('password', PasswordType::class, [
                'attr' =>[
                    'class' => 'form-control'
                ],

                'label' => 'Confirmation de mot de passe',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ],
                
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])


            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],

                'label' => 'Telephone',

                'label_attr' => [
                    'class' => 'form_label mt-4'
                ]
            ])

            ->add('Submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],

                'label' => 'S\'inscrire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
