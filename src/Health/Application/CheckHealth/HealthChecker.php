<?php

declare(strict_types=1);

namespace App\Health\Application\CheckHealth;

use App\Health\Application\GetHealthResponse;
use App\Health\Domain\Repository\HealthRepositoryInterface;

final class HealthChecker
{
    public function __construct(private readonly HealthRepositoryInterface $repository)
    {
    }

    public function __invoke(CheckHealthQuery $checkHealthQuery): GetHealthResponse
    {
        $health = $this->repository->health();
        return GetHealthResponse::ofSuccess('OK');
    }
}
