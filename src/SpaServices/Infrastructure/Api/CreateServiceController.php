<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Api;

use App\Shared\Domain\ValueObject\Uuid;
use App\SpaServices\Application\CreateService\CreateServiceCommand;
use App\SpaServices\Domain\Exceptions\ServiceAlreadyExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateServiceController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $id = Uuid::random();
        $name = (string)$request->request->get('name');
        $price = (float)$request->request->get('price');

        $this->dispatch(
            new CreateServiceCommand(
                $id->value(),
                $name,
                $price
            )
        );
        return $this->successResponse(Response::HTTP_CREATED, sprintf("Service '%s' with ID '%s' created", $name, $id->value()));
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Assert\Collection(
            [
                'name' => [new Assert\NotBlank(), new Assert\Type(["string"])],
                'price' => [new Assert\NotBlank(), new Assert\Positive(), new Assert\Type(["float"])]
            ]
        );

        $input = $request->request->all();

        return $this->requestValidation($input, $constraint);
    }

    protected function exceptions(): array
    {
        return [
            ServiceAlreadyExistsException::class => Response::HTTP_CONFLICT,
        ];
    }
}
