<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use function Lambdish\Phunctional\each;
use App\Shared\Domain\Bus\Command\CommandInterface;
use App\Shared\Domain\Bus\Query\QueryInterface;
use App\Shared\Domain\Bus\Query\QueryResponse;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Collection;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiController extends AbstractController
{

    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler

    ) {
        each(
            fn (int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions()
        );
    }

    protected function ask(QueryInterface $query): ?QueryResponse
    {
        return $this->queryBus->ask($query);
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

    public function errorResponse(int $httpCode, int $errorCode = 0, mixed $errorMessage = null): JsonResponse
    {
        return ErrorJsonResponse::create(
            $httpCode,
            [
                'errorCode' => $errorCode,
                'errorMessage' => $errorMessage
            ],
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    public function requestValidation(array $input, Collection $constraint): ?array
    {
        $validationErrors = Validation::createValidator()->validate($input, $constraint);
        if (!$validationErrors->count() > 0) return null;

        $errors = [];
        foreach ($validationErrors as $violation) {
            $errors[str_replace(['[', ']'], ['', ''], $violation->getPropertyPath())] = $violation->getMessage();
        }
        return $errors;
    }
    abstract protected function exceptions(): array;
}
