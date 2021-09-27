<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangeUserPrivilagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('admin', ChoiceType::class, [
                'label' => 'Admin Privileges',
                'choices'=>[
                    'Yes'=>true,
                    'No'=>false
                ]
            ])
            ->add('active', ChoiceType::class, [
                'label' => 'Deactivate User?',
                'choices'=>[
                    'Yes'=>false,
                    'No'=>true
                ]
            ])
            ->add('updatePrivileges', SubmitType::class, [
                'label' => 'Update'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
