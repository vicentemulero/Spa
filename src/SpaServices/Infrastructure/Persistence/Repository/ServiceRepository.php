<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Persistence\Repository;

use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceId;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;

class ServiceRepository extends DoctrineRepository implements ServiceRepositoryInterface
{
    public function store(Service $service): void
    {
        $this->persist($service);
    }
    public function findById(ServiceId $id): ?Service
    {
        return $this->repository(Service::class)->find($id);
    }
    public function findAllServices(): ?array
    {
        return $this->repository(Service::class)->findAll();
    }
}
