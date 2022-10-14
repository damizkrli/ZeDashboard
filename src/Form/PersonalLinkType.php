<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PersonalLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('url', TextType::class, [
                'label' => 'URL'
            ])
            ->add('submit', TextType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-sm btn-outline-success rounded-0'
                ]
            ])
        ;
    }
}