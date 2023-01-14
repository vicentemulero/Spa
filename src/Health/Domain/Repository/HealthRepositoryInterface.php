<?php

declare(strict_types=1);

namespace App\Health\Domain\Repository;

use App\Health\Domain\Exceptions\DatabaseNotHealthyRepositoryException;
use App\Health\Domain\Model\Health;

interface HealthRepositoryInterface
{
    /**
     * @throws DatabaseNotHealthyRepositoryException
     */
    public function health(): Health;
}
