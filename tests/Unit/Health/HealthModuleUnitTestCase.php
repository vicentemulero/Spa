<?php

declare(strict_types=1);

namespace App\Tests\Unit\Health;

use PHPUnit\Framework\MockObject\MockObject;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use App\Health\Domain\Repository\HealthRepositoryInterface;

abstract class HealthModuleUnitTestCase extends UnitTestCase
{
    private $repository;

    protected function shouldSave(): void
    {
    }

    protected function shouldSearch(): void
    {
    }

    protected function shouldFind(): void
    {
    }

    /** return HealthRepositoryInterface|MockObject */
    protected function repository(): HealthRepositoryInterface|MockObject
    {
        return $this->repository = $this->repository ?: $this->createMock(HealthRepositoryInterface::class);
    }
}
