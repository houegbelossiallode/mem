<?php

namespace App\Form;

use App\Entity\Boisson;
use App\Entity\Magasin;
use App\Repository\BoissonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MagasinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('boisson',EntityType::class,[
            'class'=> Boisson::class,
            'placeholder'=> 'Choisissez une boisson',
            
            'query_builder'=> function(BoissonRepository $cr)
            {
                return $cr->createQueryBuilder('B')
                
                ->orderBy('B.designation', 'ASC');
            }
        ])
            ->add('VALIDER',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Magasin::class,
        ]);
    }
}