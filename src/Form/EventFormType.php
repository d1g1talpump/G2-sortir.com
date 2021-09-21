<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //Dates

            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])
            ->add('limitSubDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])

            //
            ->add('maxSub')
            ->add('duration')
            ->add('infos')
            ->add('campus', EntityType::class, [
                'class' => Campus::class,

                'choice_label' => 'name',
            ])

            /*TODO
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            */
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
            ])
            /*TODO
            ->add('street', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
            ])
            */
            /*TODO
            ->add('postalCode', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            */
            /*TODO
            ->add('latitude', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
            ])
            */
            /*TODO
            ->add('longitude', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
