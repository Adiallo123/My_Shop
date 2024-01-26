<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                new Assert\Email(),
            ]
        ] )

        
        ->add('password', PasswordType::class, [
            'attr' => [
                'class' => 'form-control'
            ],

            'label' => 'Mot De Passe',

            'label_attr' => [
                'class' => 'form_label mt-4'
            ]
        ])

        ->add('Submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ],

            'label' => 'Se Connecté'
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
