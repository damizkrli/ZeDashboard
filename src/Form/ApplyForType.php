<?php

namespace App\Form;

use App\Entity\ApplyFor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyForType extends AbstractType
{
    public const PLATFORM = [
        'HelloWork' => 'HelloWork',
        'Pôle Emploi' => 'Pôle Emploi',
        'Welcome to the Jungle' => 'Welcome to the Jungle',
        'Indeed' => 'Indeed',
        'LinkedIn' => 'LinkedIn',
        'Talent.io' => 'Talent.io',
        'Les Jeudis' => 'Les Jeudis'
    ];

    public const COMPANY = [
        'ManPower' => 'Manpower',
        'CGI' => 'CGI',
        'Work&You' => 'Work&You',
        'EASY PARTNER' => 'EASY PARTNER',
        'Akema' => 'Akema',
        'NEO-Soft' => 'NEO-Soft',
        'Fortil' => 'Fortil',
        'Web Design Marchand' => 'Web Design Marchand',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', ChoiceType::class, [
                'placeholder' => 'Sélectionnez une plateforme',
                'choices' => self::PLATFORM,
                'label' => "Nom de la plateforme",
                'required' => false,
            ])
            ->add('company', ChoiceType::class, [
                'choices' => self::COMPANY,
                'placeholder' => 'Sélectionnez une entreprise',
                'label' => "Nom de l'entreprise",
                'required' => false,
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
                'label' => 'Date retour entreprise',
                'required' => false,
                'mapped' => false,
                'widget' => 'single_text',
            ])
            ->add('isRetained', CheckboxType::class, [
                'label' => 'Candidature retenue',
                'help' => 'Cocher la case si votre candidature à été retenue.',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-sm',
                ]
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
