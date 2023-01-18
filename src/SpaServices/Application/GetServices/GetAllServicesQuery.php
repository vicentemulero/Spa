<?php

declare(strict_types=1);

namespace App\SpaServices\Application\GetServices;

use App\Shared\Domain\Bus\Query\QueryInterface;

final class GetAllServicesQuery implements QueryInterface
{

    public function __construct()
    {
    }

}
