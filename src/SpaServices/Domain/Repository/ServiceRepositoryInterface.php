<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Repository;

use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\Service;

interface ServiceRepositoryInterface
{
    public function store(Service $service): void;

    public function findById(ServiceId $id): ?Service;

    public function findAllServices(): ?array;
}
