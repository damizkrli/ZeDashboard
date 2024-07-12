<?php

namespace App\Form;

use App\Entity\ApplyFor;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyForType extends AbstractType
{
    public const STATUS = [
        'Acceptée'     => 'Acceptée',
        'Appel'        => 'Appel',
        'Entretien'    => 'Entretien',
        'Refusée'      => 'Refusée',
        'Sans réponse' => 'Sans réponse',
        'Transmise'    => 'Transmise',
        'Relance'      => 'Relance'
    ];

    // TODO : Ajouter les const pour les plateformes (indeed, hellowork, France Tavail ...)
    public const PLATEFORM = [
        'Indeed' => 'Indeed',
        'HelloWork' => 'HelloWork',
        'France Travail' => 'France Travail',
        'ChooseYourBoss' => 'ChooseYourBoss',
        'Welcome to the Jungle' => 'Welcome to the Jungle',
        'Licorne Society' => 'Licorne Society',
        'WeLoveDevs' => 'WeLoveDevs',
        'Glassdoor' => 'Glassdoor',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', ChoiceType::class, [
                'choices' => self::PLATEFORM,
                'placeholder' => 'Choisissez une plateforme',
                'label'         => 'Plateforme',
                'required'      => false,
            ])
            ->add('company', TextType::class, [
                'attr' => [
                    'placeholder' => 'Concerto, Cdiscount, ...',
                ],
                'label'         => 'Entreprise',
                'required'      => false,
            ])
            ->add('contact', EntityType::class, [
                'class'         => Contact::class,
                'placeholder'   => 'Sélectionner un contact',
                'label'         => 'Nom du contact',
                'required'      => false,
                'query_builder' => function (ContactRepository $contactRepository) {
                    return $contactRepository
                        ->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ajouter des informations sur une entreprise...',
                    'rows' => 12,
                    'cols' => 5
                ]
            ])
            ->add('jobTitle', TextType::class, [
                'label' => "Intitulé du poste",
                'attr' => [
                    'placeholder' => "Développeur Web, Développeur Backend, ..."
                ]
            ])
            ->add('link', UrlType::class, [
                'label' => "Lien vers l'annonce",
                'attr' => [
                    'placeholder' => 'https://lien-vers-l-annonce.fr'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices'    => self::STATUS,
                'placeholder' => 'Choisissez un statut',
                'label'      => "Statut",
                'required'   => false,
                'empty_data' => 'Transmise',
            ])
            ->add('sent', DateType::class, [
                'label'    => 'Envoyé le ',
                'format'   => 'yyyy-MM-dd',
                'widget'   => 'single_text',
                'required' => false,
            ])
            ->add('response', DateType::class, [
                'label'    => 'Réponse le : ',
                'format'   => 'yyyy-MM-dd',
                'widget'   => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApplyFor::class,
        ]);
    }
}
