<?php

namespace App\Form;

use App\Entity\ApplyFor;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\Platform;
use App\Repository\CompanyRepository;
use App\Repository\ContactRepository;
use App\Repository\PlatformRepository;
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
        'Acceptée'  => 'Acceptée',
        'Appel'     => 'Appel',
        'Entretien' => 'Entretien',
        'Refusée'   => 'Refusée',
        'Ignorée'   => 'Ignorée',
        'Envoyée'   => 'Envoyée',
        'Relance'   => 'Relance'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices'     => self::STATUS,
                'placeholder' => 'Choisissez un statut',
                'label'       => "Statut",
                'required'    => false,
                'empty_data'  => 'Envoyée',
            ])
            ->add('platform', EntityType::class, [
                'class' => Platform::class,
                'placeholder'   => 'Choisissez une plateforme',
                'label'         => 'Plateforme',
                'required'      => false,
                'query_builder' => function (PlatformRepository $platformRepository) {
                    return $platformRepository
                        ->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
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
            ->add('company', EntityType::class, [
                'class'         => Company::class,
                'placeholder' => 'Sélectionner une enterprise',
                'label' => 'Entreprise',
                'query_builder' => function (CompanyRepository $companyRepository) {
                    return $companyRepository
                        ->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('note', TextareaType::class, [
                'label'    => 'Note',
                'required' => false,
                'attr'     => [
                    'placeholder' => 'Ajouter des informations sur une entreprise...',
                    'rows'        => 10,
                    'cols'        => 5
                ]
            ])
            ->add('jobTitle', TextType::class, [
                'label' => "Intitulé du poste",
                'attr'  => [
                    'placeholder' => "Développeur Web, Développeur Backend, ..."
                ]
            ])
            ->add('link', UrlType::class, [
                'label' => "Lien vers l'annonce",
                'attr'  => [
                    'placeholder' => 'https://lien-vers-l-annonce.fr'
                ]
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
