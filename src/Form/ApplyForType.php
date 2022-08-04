<?php

namespace App\Form;

use App\Entity\ApplyFor;
use App\Entity\Platform;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyForType extends AbstractType
{

    public const COMPANY = [
        'ManPower'            => 'Manpower',
        'CGI'                 => 'CGI',
        'Work&You'            => 'Work&You',
        'EASY PARTNER'        => 'EASY PARTNER',
        'Akema'               => 'Akema',
        'NEO-Soft'            => 'NEO-Soft',
        'Fortil'              => 'Fortil',
        'Web Design Marchand' => 'Web Design Marchand',
        'Guarani'             => 'Guarani',
    ];

    public const STATUS = [
        'Entretien' => 'Entretien',
        'Entretien Tech' => 'Entretien Tech',
        'Refusée'   => 'Refusée',
        'Acceptée'  => 'Acceptée',
        'En Attente'   => 'En Attente',
        'Sans réponse'   => 'Sans réponse',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', EntityType::class, [
                'class' => Platform::class,
                'label' => 'Plateforme',
                'mapped' => false,
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
                'label' => "Lien vers l'annonce ou vers l'entreprise"
            ])
            ->add('dateApplyFor', DateTimeType::class, [
                'label'  => 'Date de candidature',
                'widget' => 'single_text',
            ])
            ->add('dateReturn', DateTimeType::class, [
                'label'    => 'Date retour',
                'required' => false,
                'mapped'   => false,
                'widget'   => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => self::STATUS,
                'placeholder' => 'Sélectionnez un statut',
                'label' => "Statut",
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
