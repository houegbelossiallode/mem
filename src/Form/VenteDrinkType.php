<?php

namespace App\Form;

use App\Entity\Boisson;
use App\Entity\VenteDrink;
use App\Repository\BoissonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteDrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix_vente')
            ->add('quantite_boisson_vendue')
            ->add('boisson',EntityType::class,[
                'class'=> Boisson::class,
                'placeholder'=> 'Choisissez une boisson',
                
                'query_builder'=> function(BoissonRepository $cr)
                {
                    return $cr->createQueryBuilder('B')
                    
                    ->orderBy('B.designation', 'ASC');
                }
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
            'data_class' => VenteDrink::class,
        ]);
    }
}