<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Guest;
use App\Entity\Service;
use App\Entity\ServiceRequest;
use App\Enum\ServiceRequestStatus;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class,  options: [
                'label' => 'service',
                'class' => Service::class,
                'choice_label' => function (Service $service) {
                    return $service->getName()
                        . ' (' . $service->getDepartment()->getName() . ')'
                        . ' (' . $service->getAvailableFrom() . ' - ' . $service->getAvailableTo() . ')';
                },
            ])
            ->add('guest', EntityType::class, [
                'class' => Guest::class,
                'choice_label' => 'name',
                'label' => 'crud.entity.default.guest',
                'empty_data' => null,
                'required' => false,
                'choice_attr' => function (Guest $guest) {
                    return [
                        'data-room' => $guest->getRoomNumber(),
                    ];
                },
                'choice_label' => function (Guest $guest) {
                    return $guest->getName() . ' (' . $guest->getRoomNumber() . ')';
                },
            ])
            ->add('room_number', options: ['label' => 'crud.entity.default.room_number'])

            ->add('created_by', ChoiceType::class, [
                'choices' => ['system' => 0, 'employee' => 1, 'guest' => 2],
                'label' => 'crud.entity.default.created_by'
            ])
            ->add('schedule_at', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'crud.entity.default.schedule_at',
                'data' => new DateTime()
            ])
            ->add('status', EnumType::class, options: [
                'class' => ServiceRequestStatus::class,
                'label' => 'crud.entity.default.status',
                'choice_label' => fn(ServiceRequestStatus $status) => $status->translationKey(),
            ])
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => function (Employee $employee) {
                    return $employee->getName() . ' - ' . $employee->getRole() . ' (' . $employee->getDepartment()->getName() . ')';
                },
                'label' => 'crud.entity.default.employee',
                'empty_data' => null,
                'required' => false,
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
