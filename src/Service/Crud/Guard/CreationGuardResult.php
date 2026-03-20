<?php

namespace App\Service\Crud\Guard;

class CreationGuardResult
{
    public function __construct(
        private readonly bool $allowed,
        private readonly ?array $flashMessage = null,
    ) {}

    public function isAllowed(): bool
    {
        return $this->allowed;
    }

    public function getFlashMessage(): ?array
    {
        return $this->flashMessage;
    }
}
