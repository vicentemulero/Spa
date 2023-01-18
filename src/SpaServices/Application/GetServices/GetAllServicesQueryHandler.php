<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServices;


use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\SpaServices\Domain\Model\Service;

final class GetAllServicesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ServicesFinder $finder)
    {
    }

    public function __invoke(GetAllServicesQuery $query): GetAllServicesResponse
    {
        $services = $this->finder->__invoke();

        return new GetAllServicesResponse($services);
    }

}
