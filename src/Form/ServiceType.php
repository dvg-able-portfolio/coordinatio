<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Department;
use App\Entity\Service;
use App\Entity\ServiceCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', options: ['label' => 'crud.entity.default.code'])
            ->add('name', options: ['label' => 'crud.entity.default.name'])
            ->add('description', options: ['label' => 'crud.entity.default.description'])
            ->add('categories', EntityType::class, [
                'class' => ServiceCategory::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'crud.entity.default.categories'
            ])
            ->add('is_schedulable', options: ['label' => 'crud.entity.default.is_schedulable'])
            ->add('available_from', options: ['label' => 'crud.entity.default.available_from'])
            ->add('available_to', options: ['label' => 'crud.entity.default.available_to'])
            // ->add('created_at')
            // ->add('updated_at')
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => 'name',
                'label' => 'crud.entity.default.department',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
