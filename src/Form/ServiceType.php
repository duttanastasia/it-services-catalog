<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Service;

class ServiceType extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => $this->translator->trans('Name'),
            ])
            ->add('logo', FileType::class, [
                'label' => $this->translator->trans('Logo (Image file)'),
                'required' => false,
                'mapped' => false,
                'attr' => ['accept' => 'image/*'],
            ])
            ->add('description', TextareaType::class, [
                'label' => $this->translator->trans('Description'),
            ])
            ->add('category', ChoiceType::class, [
                'label' => $this->translator->trans('Category'),
                'choices' => [
                    $this->translator->trans('Cloud Solutions') => 'category.cloud_solutions',
                    $this->translator->trans('Collaboration Tools') => 'category.collaboration_tools',
                    $this->translator->trans('Project Management Systems') => 'category.project_management',
                    $this->translator->trans('Databases') => 'category.databases',
                    $this->translator->trans('Version Control Systems') => 'category.version_control',
                    $this->translator->trans('Operating Systems') => 'category.operating_systems',
                    $this->translator->trans('Virtualization and Containerization') => 'category.virtualization',
                    $this->translator->trans('Security Systems') => 'category.security_systems',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return $key;
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}

