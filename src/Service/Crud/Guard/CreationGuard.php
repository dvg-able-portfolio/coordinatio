<?php

namespace App\Service\Crud\Guard;

use App\Entity\Employee;
use App\Entity\Service;
use App\Entity\ServiceRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\DepartmentRepository;
use App\Repository\ServiceRepository;

/**
 * Guards entity creation by verifying required dependencies exist.
 * Returns a result indicating whether creation is allowed and, if not, a flash message setup.
 */
class CreationGuard
{

    public function __construct(
        private readonly DepartmentRepository $departmentRepository,
        private readonly ServiceRepository $serviceRepository,
    ) {}

    public function guard(string $entityClassName): CreationGuardResult
    {
        $result = (bool)match ($entityClassName) {
            Employee::class, Service::class => $this->validateRepositories($this->departmentRepository),
            ServiceRequest::class => $this->validateRepositories($this->departmentRepository, $this->serviceRepository),
            default => throw new \InvalidArgumentException("No guard defined for $entityClassName")
        };

        $message = null;

        if ($result === false) {
            $message = $this->parseFlashMessage($entityClassName);
        }

        return new CreationGuardResult($result, $message);
    }

    private function validateRepositories(ServiceEntityRepository ...$repositories): bool
    {
        foreach ($repositories as $repository) {
            if ($this->departmentRepository->count([]) > 0  === false) {
                return false;
            }
        }
        return true;
    }

    private function parseFlashMessage(string $entityClassName): array
    {

        [$entity, $dependency] = match ($entityClassName) {
            Employee::class => ['employee', ['department']],
            Service::class =>  ['service', ['department']],
            ServiceRequest::class =>  ['service_request', ['department', 'service']],
            default => ['unknown', ['unknown']]
        };

        return [
            'warning',
            [
                'key'    => 'crud.flash.no_entries_for_creation',
                'params' => [
                    '%entity%' => $entity,
                    '%dependency%' => $dependency
                ],
            ]
        ];
    }
}
