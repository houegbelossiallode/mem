<?php

namespace App\Form;

use App\Entity\Proteine;
use App\Entity\Repas;
use App\Entity\VenteRepas;
use App\Repository\ProteineRepository;
use App\Repository\RepasRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteRepasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('repas',EntityType::class,[
            'class'=> Repas::class,
            'placeholder'=> 'Choisissez un repas',
            'required' => false,
            'query_builder'=> function(RepasRepository $cr)
            {
                return $cr->createQueryBuilder('r')
                
                ->orderBy('r.accompagnement', 'ASC');
            }
        ])
        ->add('proteine',EntityType::class,[
            'class'=> Proteine::class,
            'placeholder'=> 'Choisissez une protéine',
            'required' => false,
            'query_builder'=> function(ProteineRepository $cr)
            {
                return $cr->createQueryBuilder('p')
                
                ->orderBy('p.nom', 'ASC');
            }
        ])
            ->add('prix_vente',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
            ->add('qte_vendue',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
            ->add('date',DateType::class,[
                'widget' => 'single_text',
                'label'=> 'Date' 
            ])
            ->add('mode_paiement',ChoiceType::class,[
                'label'=> 'Mode de paiement',
                'placeholder'=> 'Choisissez un mode de paiement',
                'choices'=>[
                    'Paiement Numéraire'=> 'Paiement Numéraire',
                    'Paiement Electronique'=> 'Paiement Electronique',
                ],
            ])
            ->add('VALIDER',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VenteRepas::class,
        ]);
    }
}