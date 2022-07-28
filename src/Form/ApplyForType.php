<?php

namespace App\Form;

use App\Entity\ApplyFor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyForType extends AbstractType
{
    const PLATFORM = [
        'HellowWork' => 'HelloWork',
        'Pôle Emploi' => 'Pôle Emploi',
        'Welcome to the Jungle' => 'Welcome to the Jungle',
        'Indeed' => 'Indeed',
        'LinkedIn' => 'LinkedIn',
        'Talen.io' => 'Talen.io',
        'Les Jeudis' => 'Les Jeudis'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', ChoiceType::class, [
                'placeholder' => 'Selectionnez une plateforme',
                'choices' => self::PLATFORM,
                'label' => "Nom de la plateforme",
                'required' => false,
            ])
            ->add('company', TextType::class, [
                'label' => "Nom de l'entreprise",
            ])
            ->add('jobTitle', TextType::class, [
                'label' => "Intitulé du poste"
            ])
            ->add('link', UrlType::class, [
                'label' => "Lien vers l'annonce"
            ])
            ->add('dateApplyFor', DateTimeType::class, [
                'label' => 'Date de candidature',
                'widget' => 'single_text',
                ])
            ->add('dateReturn', DateTimeType::class, [
                'label' => 'Date de retour',
                'required' => false,
                'mapped' => false,
                'widget' => 'single_text',
                ])
            ->add('isRetained')
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplyFor::class,
        ]);
    }
}
