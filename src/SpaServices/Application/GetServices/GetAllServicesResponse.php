<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServices;


use App\Shared\Domain\Bus\Query\QueryResponse;

final class GetAllServicesResponse implements QueryResponse
{
    private array $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function services(): array
    {
        return $this->services;
    }
}
