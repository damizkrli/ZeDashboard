<?php

namespace App\Form;

use App\Entity\ApplyFor;
use App\Entity\Company;
use App\Entity\Platform;
use App\Repository\ApplyForRepository;
use App\Repository\CompanyRepository;
use App\Repository\PlatformRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyForType extends AbstractType
{
    public const STATUS = [
        'Acceptée'       => 'Acceptée',
        'Appel'          => 'Appel',
        'Entretien'      => 'Entretien',
        'Refusée'        => 'Refusée',
        'Sans réponse'   => 'Sans réponse',
        'Transmise'      => 'Transmise',
        'Relance'        => 'Relance'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', EntityType::class, [
                'class'         => Platform::class,
                'placeholder'   => 'Sélectionnez une plateforme',
                'label'         => 'Plateforme',
                'required'      => false,
                'query_builder' => function (PlatformRepository $platformRepository) {
                    return $platformRepository
                        ->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                }
            ])
            ->add('company', EntityType::class, [
                'class'         => Company::class,
                'placeholder'   => 'Sélectionnez une entreprise',
                'label'         => "Nom de l'entreprise",
                'query_builder' => function (CompanyRepository $companyRepository) {
                    return $companyRepository
                        ->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                }
            ])
            ->add('contact', TextType::class, [
                'label'    => 'Contact',
                'required' => false
            ])
            ->add('details', TextType::class, [
                'label'    => 'Coordonnées',
                'required' => false,
            ])
            ->add('jobTitle', TextType::class, [
                'label' => "Intitulé du poste"
            ])
            ->add('link', UrlType::class, [
                'label' => "Lien vers l'annonce"
            ])
            ->add('status', ChoiceType::class, [
                'choices'       => self::STATUS,
                'label'         => "Statut",
                'required'      => false,
                'empty_data'    => 'Transmise',
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
