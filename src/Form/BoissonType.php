<?php

namespace App\Form;

use App\Entity\Boisson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoissonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation',TextType::class,[
                'attr' => array('class'=> 'text-uppercase'),
            ])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    
                    'Bière'=> 'Bière',
                    'Sucrerie'=> 'Sucrerie',
                    'Vin'=> 'Vin',
                    'Eau'=> 'Eau',
                    'Autres'=> 'Autres',
                ],
            ])
            ->add('seuil')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boisson::class,
        ]);
    }
}