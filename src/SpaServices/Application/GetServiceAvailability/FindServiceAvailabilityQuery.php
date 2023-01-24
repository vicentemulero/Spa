<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServiceAvailability;

use App\Shared\Domain\Bus\Query\QueryInterface;

final class FindServiceAvailabilityQuery implements QueryInterface
{

    public function __construct(private readonly string $id, private readonly string $day)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function day(): string
    {
        return $this->day;
    }
}
