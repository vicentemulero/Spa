<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServices;

use App\SpaServices\Domain\Exceptions\ServicesNotExistsException;
use App\SpaServices\Domain\Model\Service;
use App\SpaServices\Domain\Repository\ServiceRepositoryInterface;

final class ServicesFinder
{
    public function __construct(private readonly ServiceRepositoryInterface $repository)
    {
    }

    public function __invoke(): array
    {
        $services = $this->repository->findAllServices();

        if (null === $services) {
            throw new ServicesNotExistsException();
        }

        return $this->transformService($services);
    }

    private function transformService(array $services): array
    {

        $servicesAvailable = ["--- Services ---"];

        /** @var Service $service */
        foreach ($services as $service) {
            $servicesAvailable[] = ["ID: " => $service->id()->value(), "Name: " => $service->name()->value(),
                "Price" => $service->price()->value(), "Created at: " => $service->createdAt()->format('d/m/Y')];
        }

        return $servicesAvailable;
    }
}
