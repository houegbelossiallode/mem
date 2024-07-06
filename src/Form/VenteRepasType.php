<?php

namespace App\Form;

use App\Entity\Calibre;
use App\Entity\CalibreRepas;
use App\Entity\Proteine;
use App\Entity\Repas;
use App\Entity\VenteRepas;
use App\Repository\ProteineRepository;
use App\Repository\CalibreRepository;
use App\Repository\RepasRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Doctrine\ORM\EntityManagerInterface;




class VenteRepasType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('repas',EntityType::class,[
            'class'=> Repas::class,
            'label'=> 'Accompagnement',
            'placeholder'=> 'Choisissez un repas',
            'attr'=> ['class'=> 'repas_select'],
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
            'attr'=> ['class'=> 'proteine_select'],
            'required' => false,
            
            'query_builder'=> function(ProteineRepository $cr)
            {
                return $cr->createQueryBuilder('p')
                ->orderBy('p.nom', 'ASC');
            }
        ])
        
        
            ->add('prix_vente_accompagnement',EntityType::class,[
                'label'=> 'Prix de l\'accompagnement',
                'class'=> CalibreRepas::class,
                'choice_label'=> 'prix',
                 'placeholder'=> 'Choisir le prix',
                 'attr'=> ['class'=> 'accompagnement_select'],
                 'required'=> false,
                 'choices'=> [],
                 'mapped'=> true,

            ])

            ->add('prix_vente_proteine',EntityType::class,[
                'label'=> 'Prix de la proteine',
                'class'=> Calibre::class,
                'choice_label' => 'masse',
                 'placeholder'=> 'Choisir le prix',
                 'attr'=> ['class'=> 'calibre_select'],
                 'required'=> false,
                // 'disabled'=> true,
                'choices'=> [],
                'mapped'=> true,
                ])


            
            ->add('qte_vendue',NumberType::class,[
                'label'=> 'Quantité vendue Proteine',
                'invalid_message' => 'Saisissez des chiffers uniquement',
                'required' => false,
                'attr' => array(
                    'style' => 'display: none',
                    'class'=> 'proteine'
                ),
                
            ])
            ->add('qte',NumberType::class,[
                'label'=> 'Quantité vendue Accompagnement',
                'invalid_message' => 'Saisissez des chiffers uniquement',
                'required' => false,
                'attr' => array(
                    'style' => 'display: none',
                    'class'=> 'repas'
                ),
            ])
            ->add('date',DateType::class,[
                'widget' => 'single_text',
                'label'=> 'Date',
                'input'=> 'datetime',
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
            ->add('VALIDER',SubmitType::class)

            
        ;



// Ajoutez un événement pour mettre à jour les communes en fonction du département sélectionné
$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
    $form = $event->getForm();
    $data = $event->getData();

if (isset($data['proteine'])) {
    $proteineId = $data['proteine'];

    // Chargez les calibres pour la protéine  sélectionnée
    $calibres = $this->entityManager->getRepository(Calibre::class)->findBy(['proteine' => $proteineId]);

    $form->add('prix_vente_proteine',EntityType::class,[
            'label'=> 'Prix de la proteine',
            'class'=> Calibre::class,
            'choice_label' => 'masse',
             'placeholder'=> 'Choisir le prix',
             'attr'=> ['class'=> 'calibre_select'],
             'required'=> false,
            // 'disabled'=> true,
            'choices'=> $calibres,
            'mapped'=> true,
            ]);
        }
    });



// Ajoutez un événement pour mettre à jour les communes en fonction du département sélectionné
$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
    $form = $event->getForm();
    $data = $event->getData();

if (isset($data['repas'])) {
    $repasId = $data['repas'];

    // Chargez les calibres pour la protéine  sélectionnée
    $calibre_repas = $this->entityManager->getRepository(CalibreRepas::class)->findBy(['repas' => $repasId]);

    $form->add('prix_vente_accompagnement',EntityType::class,[
        'label'=> 'Prix de l\'accompagnement',
        'class'=> CalibreRepas::class,
        'choice_label'=> 'prix',
         'placeholder'=> 'Choisir le prix',
         'attr'=> ['class'=> 'accompagnement_select'],
         'required'=> false,
         'choices'=> $calibre_repas,
         'mapped'=> true,
          
            ]);
        }
    });



    





        
    }



    







    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VenteRepas::class,
        ]);
    }
}