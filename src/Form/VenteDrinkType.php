<?php

namespace App\Form;

use App\Entity\Boisson;
use App\Entity\VenteDrink;
use App\Repository\BoissonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class VenteDrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix_vente',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
            ->add('quantite_boisson_vendue',NumberType::class,[
                'invalid_message' => 'Saisissez des chiffers uniquement',
            ])
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
                'label'=> 'Date',
                'constraints' => [
                    new LessThanOrEqual('today'),
                    
                ],
            ])
            ->add('mode_paiement',ChoiceType::class,[
                'label'=> 'Mode de paiement',
                'placeholder'=> 'Choisissez un mode de paiement',
                'choices'=>[
                    'Paiement Numéraire'=> 'Paiement Numéraire',
                    'Paiement Electronique'=> 'Paiement Electronique',
                ],
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