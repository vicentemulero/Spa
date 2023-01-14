<?php

declare(strict_types=1);

namespace App\Health\Infrastructure\Repository;

use App\Health\Domain\Model\Health;
use App\Health\Domain\Repository\HealthRepositoryInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use App\Health\Domain\Exceptions\DatabaseNotHealthyRepositoryException;

class HealthRepository extends DoctrineRepository implements HealthRepositoryInterface
{
    public function health(): Health
    {
        return new Health(200);
        try {
            $stmt = $this->connection->prepare("SELECT 1+1");
            return new Health($stmt->executeQuery()->fetchOne());
        } catch (\Throwable $th) {
            $this->logger->error($th->getMessage());
            throw new DatabaseNotHealthyRepositoryException($th->getMessage());
        }
    }
}
