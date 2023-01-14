<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\QueryInterface;
use App\Shared\Domain\Bus\Query\QueryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ApiController extends AbstractController
{
    private CommandBus $commandBus;
    private QueryBus   $queryBus;

    public function __construct(
        CommandBus $commandBus,
        QueryBus $queryBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler
    ) {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;

        foreach ($this->exceptions() as $exceptionClass => $httpCode) {
            $exceptionHandler->register($exceptionClass, $httpCode);
        }
    }

    abstract protected function exceptions(): array;

    protected function ask(QueryInterface $query): ?QueryResponse
    {
        return $this->queryBus->dispatch($query);
    }

    protected function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function successResponse(int $httpCode = 200, mixed $data = null): JsonResponse
    {
        return SuccessJsonResponse::create(
            $httpCode,
            $data,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}
