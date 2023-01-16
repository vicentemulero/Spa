<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use App\Shared\Domain\ClassUtils;
use App\Shared\Domain\DomainError;
use App\Shared\Domain\StringUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

final class ApiExceptionListener
{
    private ApiExceptionsHttpStatusCodeMapping $exceptionHandler;

    public function __construct(ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $domainErrorClass = DomainError::class;
        if ($exception instanceof $domainErrorClass) {
            $statusCode = $this->exceptionHandler->statusCodeFor(get_class($exception));
            if (Response::HTTP_INTERNAL_SERVER_ERROR !== $statusCode) {
                $event->allowCustomResponseCode();
            }

            $event->setResponse(
                new JsonResponse(
                    [
                        'code' => $this->exceptionCodeFor($exception),
                        'message' => $exception->getMessage(),
                    ],
                    $statusCode
                )
            );
        }
    }

    private function exceptionCodeFor(Throwable $error): string
    {
        $domainErrorClass = DomainError::class;

        return $error instanceof $domainErrorClass
            ? $error->errorCode()
            : StringUtils::toSnakeCase(ClassUtils::extractClassName($error));
    }
}
