<?php

declare(strict_types=1);

namespace App\Reservations\Infrastructure\Api;

use App\Reservations\Application\CreateReservation\CreateReservationCommand;
use App\Reservations\Domain\Exceptions\ReservationNotAllowedException;
use App\Shared\Domain\ValueObject\Uuid;
use App\SpaServices\Domain\Exceptions\ServiceNotExistsException;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateReservationController extends ApiController
{
    public function __invoke(Request $request): Response
    {
        $validationErrors = $this->validateRequest($request);

        if (!is_null($validationErrors)) return $this->errorResponse(Response::HTTP_BAD_REQUEST, 9001, $validationErrors);

        $serviceId = $request->attributes->get('serviceId');
        $clientName = (string)$request->request->get('client_name');
        $clientEmail = (string)$request->request->get('client_email');
        $reservedDay = (string)$request->request->get('reserved_day');
        $reservedTime = (string)$request->request->get('reserved_time');

        if ($this->isValidDate($reservedDay)) {
            return $this->errorResponse(
                Response::HTTP_BAD_REQUEST,
                500,
                "You are trying to book a day less than the current date");
        }

        $reservationDate = DateTime::createFromFormat('d/m/Y H:i', $request->get('reserved_day') . ' ' . $request->get('reserved_time'));
        if ($reservationDate->format('d/m/Y') == (new DateTime())->format('d/m/Y')) {
            if ($reservationDate <= (new DateTime())) {
                return $this->errorResponse(
                    Response::HTTP_BAD_REQUEST,
                    500,
                    "You are trying to book a time that has already passed on the given day");
            }
        }

        $this->dispatch(
            new CreateReservationCommand(
                $serviceId,
                $clientName,
                $clientEmail,
                $reservedDay,
                $reservedTime
            )
        );
        return $this->successResponse(Response::HTTP_CREATED,
            sprintf("Reservation for Service '%s' booked correctly", $serviceId));
    }

    private function validateRequest(Request $request): ?array
    {
        $constraint = new Assert\Collection(
            [
                'client_name' => [new Assert\NotBlank(), new Assert\Type(["string"])],
                'client_email' => [new Assert\NotBlank(), new Assert\Type(["string"]), new Assert\Email()],
                'reserved_day' => [new Assert\NotBlank(), new Assert\Type(["string"]), new Assert\Regex(['pattern' => '#^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/([0-9]{4})$#'])],
                'reserved_time' => [new Assert\NotBlank(), new Assert\Type(["string"]), new Assert\Regex(['pattern' => '#^(0[0-9]|1[0-9]|2[0-3]):00$#'])]
            ]
        );

        $input = $request->request->all();

        return $this->requestValidation($input, $constraint);
    }

    private function isValidDate(string $date): bool
    {
        $now = new DateTime();
        $now->setTime(0, 0);
        $reservedDay = DateTime::createFromFormat('d/m/Y', $date);
        $reservedDay->setTime(0, 0);
        return $now >= $reservedDay;
    }

    protected function exceptions(): array
    {
        return [
            ServiceNotExistsException::class => Response::HTTP_NOT_FOUND,
            ReservationNotAllowedException::class => Response::HTTP_NOT_FOUND
        ];
    }
}
