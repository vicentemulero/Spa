<?php

declare(strict_types=1);

namespace App\Health\Application\CheckHealth;

use App\Health\Application\GetHealthResponse;
use App\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class CheckHealthQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly HealthChecker $checker)
    {
    }

    public function __invoke(CheckHealthQuery $query): GetHealthResponse
    {
        return $this->checker->__invoke($query);
    }
}
