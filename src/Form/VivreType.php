<?php

namespace App\Form;

use App\Entity\Proteine;
use App\Entity\Vivre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('proteine',EntityType::class,[
                'class'=> Proteine::class,
                'label'=> 'PROTEINE',
                'placeholder'=> 'Choisissez un proteine',
                'attr'=> ['class'=> 'article-select'],
            ])
            ->add('text', TextType::class, [
                'label' => 'Champ à afficher',
                'required' => false, // Rendre facultatif pour ne pas afficher par défaut
                'attr' => [
                    'class' => 'article-input',
                    'style' => 'display: none;', // Masquer par défaut
                ],
            ])
            ->add('VALIDER',SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vivre::class,
        ]);
    }
}