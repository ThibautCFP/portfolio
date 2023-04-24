<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Project;
use App\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Symfony web site'
                ],
            ])
            ->add('content', HiddenType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description du projet'
                ],
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'query_builder' => function (SkillRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->where('s.enabled = true');
                },
                'choice_label' => 'title',
                'label' => 'Compétences',
                'placeholder' => 'Sélectionner des Compétences',
                'by_reference' => false,
                'multiple' => true,
                'expanded' => false,
                'autocomplete' => true,
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ProjectImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->add('files', CollectionType::class, [
                'entry_type' => ProjectFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
