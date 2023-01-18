<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Api;

use App\SpaServices\Application\GetServiceAvailability\FindServiceAvailabilityQuery;
use App\SpaServices\Application\GetServiceAvailability\ServiceAvailabilityResponse;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints as Assert;

final class GetServiceAvailabilityController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $id = $request->attributes->get('id');

        if (!Uuid::isValid($id)) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, 'Not valid UUID format');
        }

        $day = (string)$request->request->get('day');

        /** @var ServiceAvailabilityResponse $response */
        $response = $this->ask(new FindServiceAvailabilityQuery($id, $day));

        return $this->successResponse(Response::HTTP_OK,  $response->serviceAvailability());
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Collection(
            [
                'day' => [new NotBlank(), new Type(["string"]),
                    new Assert\Regex(['pattern' => '#^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$#'])]
            ]
        );

        $input = $request->request->all();

        return $this->requestValidation($input, $constraint);
    }

    protected function exceptions(): array
    {
        return [
            ServiceNotExistsException::class => Response::HTTP_NOT_FOUND,
        ];
    }
}
