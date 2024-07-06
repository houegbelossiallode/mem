<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles',ChoiceType::class,[
                
                'placeholder'=> 'Sélectionnez un rôle',
                'choices'=>[
                    'ROLE_USER'=> 'ROLE_USER',
                    'ROLE_ADMIN'=> 'ROLE_ADMIN'
                ],
                'expanded'=>true,
                'multiple'=> true
            ])
          //  ->add('password')
            ->add('nom')
           // ->add('isVerified')
           // ->add('prenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}