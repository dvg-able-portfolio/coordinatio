<?php

namespace App\Form;

use App\Entity\ServiceCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', options: ['label' => 'crud.entity.default.code'])
            ->add('name', options: ['label' => 'crud.entity.default.name'])
            ->add('description', options: ['label' => 'crud.entity.default.description'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceCategory::class,
        ]);
    }
}
