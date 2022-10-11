<?php

namespace App\Form;

use App\Entity\ApplyFor;
use App\Entity\Company;
use App\Entity\Platform;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
    public const STATUS = [
        'Transmise' => 'Transmise',
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
                'placeholder' => 'Sélectionnez une plateforme',
                'label' => 'Plateforme',
                'mapped' => false,
                'required' => false,
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'placeholder' => 'Sélectionnez une entreprise',
                'label' => "Nom de l'entreprise",
                'mapped' => false
            ])
            ->add('name', TextType::class, [
                'label' => 'Personne à contacter',
                'required' => false
            ])
            ->add('details', TextType::class, [
                'label' => 'Coordonnées de la personne à contacter',
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
                'required' => false
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
                'required' => false,
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
