<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Sponsor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre')
            ->add('dateEvent')
           // ->add('sponsorevent')
           ->add('image', FileType::class, ['label'=>'images jpeg'
           
           ])
            ->add('sponsorevent', EntityType::class, ['class'=>Sponsor::class,
            'choice_label'=>'nomSponsor',
            'label'=>'Sponsorisé par '
           
            ]
          
        )
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
