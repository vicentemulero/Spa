<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Api;

use App\SpaServices\Application\CreateServiceSchedule\CreateServiceScheduleCommand;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

final class CreateScheduleServiceController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);;

        $id = $request->attributes->get('id');
        $dayAvailable = (string)$request->request->get('day_available');
        $availableFrom = (string)$request->request->get('available_from');
        $availableTo = (string)$request->request->get('available_to');


        $this->dispatch(
            new CreateServiceScheduleCommand(
                $id,
                $dayAvailable,
                $availableFrom,
                $availableTo
            )
        );
        return $this->successResponse(Response::HTTP_CREATED, sprintf("Shedule for Service '%s' added correctly", $id));
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Collection(
            [
                'day_available' => [new NotBlank(), new Type(["string"]), new Assert\Regex(['pattern' => '#^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$#']),
                    new Assert\GreaterThan(['value' => (new DateTime())->format("d/m/Y")])],
                //Ensures that a date equal to or less than the current date cannot be added
                'available_from' => [new NotBlank(), new Type(["string"]),
                    new Assert\Regex(['pattern' => '#^(0[0-9]|1[0-9]|2[0-3]):00$#'])],
                //This pattern ensures that you cannot add an hour that does not contain 00 in the minutes.
                'available_to' => [new NotBlank(), new Type(["string"]), new Assert\Regex(['pattern' => '#^(0[0-9]|1[0-9]|2[0-3]):00$#']),
                    new Assert\GreaterThan(['value' => $request->request->get('available_from')])]
                //Ensures that available to is greater than available from
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
