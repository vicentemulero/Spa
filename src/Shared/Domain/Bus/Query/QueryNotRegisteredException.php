<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus\Query;

final class QueryNotRegisteredException extends \RuntimeException
{
    private QueryInterface $query;

    public function __construct(QueryInterface $command)
    {
        parent::__construct(sprintf('Query %s not registered', get_class($command)));
        $this->query = $command;
    }
}
