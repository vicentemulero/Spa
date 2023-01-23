<?php

declare(strict_types=1);

namespace App\Tests\Unit\SpaService;


use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class ServiceUnitTestCase extends UnitTestCase
{
    private ServiceRepositoryInterface|MockObject|null $repository;

    protected function shouldSave(Service $service): void
    {
        $this->repository()
            ->method('store')
            ->with($service);
    }

    protected function shouldFind(ServiceId $id, ?Service $service): void
    {
        $this->repository()
            ->method('findById')
            ->with($id)
            ->willReturn($service);
    }

    protected function shouldFindAll(?array $services = []): void
    {
        $this->repository()
            ->method('findAllServices')
            ->willReturn($services);
    }

    protected function repository(): ServiceRepositoryInterface|MockObject
    {
        return $this->repository = $this->repository ?? $this->mock(ServiceRepositoryInterface::class);
    }
}
