<?php

declare(strict_types=1);

namespace App\Enum;

use Finite\State;
use Finite\Transition\Transition;

enum ServiceRequestStatus: string implements State
{
    case CREATED = 'created';
    case OPEN = 'open';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
    case CANCELLED = 'cancelled';


    public static function getTransitions(): array
    {
        return [
            new Transition('open', [self::CREATED], self::OPEN),
            new Transition('assign', [self::OPEN], self::ASSIGNED),
            new Transition('progress', [self::ASSIGNED], self::IN_PROGRESS),
            new Transition('finish', [self::IN_PROGRESS], self::DONE),
            new Transition('cancel', [self::IN_PROGRESS,self::OPEN,self::ASSIGNED,self::IN_PROGRESS], self::CANCELLED),
        ];
    }

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
