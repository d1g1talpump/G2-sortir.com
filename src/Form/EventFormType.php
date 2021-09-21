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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')

            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])
            ->add('limitSubDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])

            ->add('maxSub')
            ->add('duration')
            ->add('infos')

            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => 'name',
            ])

            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
