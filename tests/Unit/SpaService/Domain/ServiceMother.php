<?php

declare(strict_types=1);

namespace App\Tests\Unit\SpaService\Domain;

use App\Shared\Domain\SpaValueObject\ServiceId;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceName;
use App\SpaServices\Domain\Model\ServicePrice;

final class ServiceMother
{
    public static function create(
        ?ServiceId    $id = null,
        ?ServiceName  $serviceName = null,
        ?ServicePrice $servicePrice = null,

    ): Service
    {
        return Service::create(
            $id ?? ServiceId::random(),
            $serviceName ?? ServiceNameMother::create(),
            $servicePrice ?? ServicePriceMother::create(),
        );
    }
}
