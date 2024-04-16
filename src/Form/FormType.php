<?php

namespace App\Form;

use App\Entity\VenteDrink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix_vente')
            ->add('quantite_boisson_vendue')
            ->add('date')
            ->add('montant')
            ->add('Statut')
            ->add('boisson')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VenteDrink::class,
        ]);
    }
}
