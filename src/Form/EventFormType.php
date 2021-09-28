<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $city = new City();
        $builder
            ->add('name')
            ->add('startDate'
                , DateTimeType::class, ['widget' => 'single_text',
//                'input'  => 'datetime_immutable',
//                'required' => false,
                ]
            )
            ->add('limitSubDate',
                DateTimeType::class
                , ['widget' => 'single_text',
//                'input'  => 'datetime_immutable',
                ]
            )
            ->add('maxSub')
            ->add('duration')
            ->add('infos')
            ->add('city', EntityType::class, [
                'mapped' => false,
                'class' => City::class,
                'choice_label' => 'name'
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name'
            ])
            ->add('createEvent', SubmitType::class, [
                'label' => 'Save For Later',
            ])
            ->add('publishEvent', SubmitType::class, [
                'label' => 'Publish Now'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
