<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: ['label' => 'crud.entity.default.name'])
            ->add('room_number', options: ['label' => 'crud.entity.default.room_number'])
            ->add('session_token', options: ['label' => 'crud.entity.default.session_token'])
            ->add('checked_in_at', options: ['label' => 'crud.entity.default.checked_in_at'])
            // ->add('check_out_at')
            // ->add('created_at')
            // ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
