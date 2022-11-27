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

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('platform', TextType::class, [
                'label'         => 'Plateforme',
                'required'      => false,
            ])
            ->add('company', TextType::class, [
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
            ->add('note', CKEditorType::class, [
                'label' => 'Note'
            ])
            ->add('jobTitle', TextType::class, [
                'label' => "Intitulé du poste"
            ])
            ->add('link', UrlType::class, [
                'label' => "Lien vers l'annonce"
            ])
            ->add('status', ChoiceType::class, [
                'choices'    => self::STATUS,
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
