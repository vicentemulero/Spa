<?php

declare(strict_types=1);

namespace App\Health\Application\CheckHealth;

use App\Shared\Domain\Bus\Query\QueryInterface;


final class CheckHealthQuery implements QueryInterface
{

    public function __construct()
    {
    }
}
