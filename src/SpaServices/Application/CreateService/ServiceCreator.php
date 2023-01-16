<?php

declare(strict_types=1);

namespace App\SpaServices\Application\CreateService;

use App\Shared\Domain\Bus\Event\EventBus;
use App\SpaServices\Domain\Exceptions\ServiceAlreadyExistsException;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Model\ServiceId;
use App\SpaServices\Domain\Model\ServiceName;
use App\SpaServices\Domain\Model\ServicePrice;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;

final class ServiceCreator
{

    public function __construct(
        private readonly ServiceRepositoryInterface $repository,
        private readonly EventBus                   $bus
    )
    {
    }

    public function __invoke(
        ServiceId    $id,
        ServiceName  $name,
        ServicePrice $price
    ): void
    {
        if (!is_null($this->repository->findById($id))) {
            throw new ServiceAlreadyExistsException($id->value());
        }

        $service = Service::create($id, $name, $price);

        $this->repository->store($service);
        $this->bus->publish(...$service->pullDomainEvents());
    }
}

