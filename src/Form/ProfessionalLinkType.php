<?php

namespace App\Form;

use App\Entity\ProfessionalLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionalLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du lien',
                'attr' => [
                    'placeholder' => 'Google'
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => 'URL',
                'attr' => [
                    'placeholder' => 'https://www.google.fr'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfessionalLink::class,
        ]);
    }
}