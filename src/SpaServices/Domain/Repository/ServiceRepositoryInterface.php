<?php

declare(strict_types=1);

namespace App\SpaServices\Domain\Repository;

use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceId;

interface ServiceRepositoryInterface
{
    public function store(Service $service): void;

    public function findById(ServiceId $id): ?Service;

}
