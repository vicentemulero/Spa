<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServiceAvailability;


use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\Shared\Domain\SpaValueObject\ServiceId;

final class FindServiceAvailabilityQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ServiceAvailabilityFinder $finder)
    {
    }

    public function __invoke(FindServiceAvailabilityQuery $query): ServiceAvailabilityResponse
    {
        $serviceAvailability = $this->finder->__invoke(new ServiceId($query->id()), $query->day());

        return new ServiceAvailabilityResponse($serviceAvailability);
    }


}
