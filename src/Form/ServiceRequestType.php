<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Guest;
use App\Entity\ServiceRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('room_number', options: ['label' => 'crud.entity.default.room_number'])
            ->add('created_by', options: ['label' => 'crud.entity.default.created_by'])
            ->add('schedule_at', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'crud.entity.default.schedule_at',
            ])
            ->add('status', options: ['label' => 'crud.entity.default.status'])
            // ->add('created_at')
            // ->add('updated_at')
            ->add('guest', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'name',
                'label' => 'crud.entity.default.guest',
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'name',
                'label' => 'crud.entity.default.employee',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceRequest::class,
        ]);
    }
}
