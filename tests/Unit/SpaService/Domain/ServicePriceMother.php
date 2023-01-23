<?php

declare(strict_types=1);

namespace App\Tests\Unit\SpaService\Domain;

use App\SpaServices\Domain\Model\ServicePrice;
use App\Tests\Shared\Domain\FloatMother;

final class ServicePriceMother
{
    public static function create(?float $value = null): ServicePrice
    {
        return new ServicePrice($value ?? FloatMother::random());
    }
}
