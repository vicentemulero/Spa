<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServiceAvailability;


use App\Shared\Domain\Bus\Query\QueryResponse;

final class ServiceAvailabilityResponse implements QueryResponse
{
    private array $availabilities;

    public function __construct(array $availabilities)
    {
        $this->availabilities = $availabilities;
    }


    public function serviceAvailability(): array
    {
        return $this->availabilities;
    }
}
