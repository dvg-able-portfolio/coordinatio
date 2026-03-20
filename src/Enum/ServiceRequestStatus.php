<?php

declare(strict_types=1);

namespace App\Enum;

enum ServiceRequestStatus: string
{
    case CREATED = 'created';
    case OPEN = 'open';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';


    public function translationKey(): string
    {
        return match ($this) {
            self::CREATED        => 'enum.service_request.status.created',
            self::OPEN        => 'enum.service_request.status.open',
            self::ASSIGNED    => 'enum.service_request.status.assigned',
            self::IN_PROGRESS => 'enum.service_request.status.in_progress',
            self::DONE        => 'enum.service_request.status.done',
            self::CANCELLED   => 'enum.service_request.status.cancelled',
        };
    }
}
