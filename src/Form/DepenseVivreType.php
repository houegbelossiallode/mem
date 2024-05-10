<?php

namespace App\Form;

use App\Entity\DepenseVivre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepenseVivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation',TextType::class,[
                'attr' => array('class'=> 'text-uppercase'),
            ])
            ->add('quantite',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
            ->add('prix',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
            ->add('date',DateType::class,[
                'widget' => 'single_text',
                'label'=> 'Date' 
            ])
            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DepenseVivre::class,
        ]);
    }
}