<?php

declare(strict_types=1);

namespace App\Tests\Unit\Health\Application\Service;

use App\Tests\Unit\Health\HealthModuleUnitTestCase;
use App\Health\Application\CheckHealth\HealthChecker;
use App\Health\Application\CheckHealth\CheckHealthQuery;
use App\Health\Domain\Exceptions\DatabaseNotHealthyRepositoryException;

class GetHealthHandlerTest extends HealthModuleUnitTestCase

{
    private HealthChecker|null $checker;


    protected function setUp(): void
    {
        parent::setUp();
        $this->checker = new HealthChecker($this->repository());
    }

    public function testReturnGetHealthResponseOk(): void
    {
        $handlerResponse = $this->checker->__invoke(new CheckHealthQuery());

        $this->assertEquals(1, $handlerResponse->getStatus());
    }

    public function testReturnGetHealthResponseFailIfRepositoryFails(): void
    {
        $this->expectException(DatabaseNotHealthyRepositoryException::class);

        $this->repository()
            ->method('health')
            ->will($this->throwException(new DatabaseNotHealthyRepositoryException()));
        $handlerResponse = $this->checker->__invoke(new CheckHealthQuery());

        $this->assertEquals(-1, $handlerResponse->getStatus());
    }
}
