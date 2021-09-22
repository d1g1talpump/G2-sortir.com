<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Event;
use App\Entity\Place;
use App\Entity\Status;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $city = new City();
        $builder
            ->add('name')

            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'required' => false,
            ])

            ->add('limitSubDate', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
            ])

            ->add('maxSub')
            ->add('duration')
            ->add('infos')


            ->add("city", EntityType::class, [
                'mapped' => false,
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Cities',
            ])

            ->add('place',EntityType::class,[
                'class'=>Place::class,
                'choice_label'=>'name',

                //Je peux rajouter une requete pour trier la façon dont je vais afficher.

                'query_builder'=>function(EntityRepository $repo) {

                    return $repo->createQueryBuilder('p')
                        ->andWhere('p.city = 1')
                        ->addOrderBy('p.name','ASC');
                }
            ])

            ->add('createEvent', SubmitType::class)
            ->add('publishEvent', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
