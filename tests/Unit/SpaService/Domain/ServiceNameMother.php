<?php

declare(strict_types=1);

namespace App\Tests\Unit\SpaService\Domain;

use App\SpaServices\Domain\Model\ServiceName;
use App\Tests\Shared\Domain\WordMother;

final class ServiceNameMother
{
    public static function create(?string $value = null): ServiceName
    {
        return new ServiceName($value ?? WordMother::random());
    }
}
