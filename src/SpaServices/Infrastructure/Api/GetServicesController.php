<?php

declare(strict_types=1);

namespace App\SpaServices\Infrastructure\Api;

use App\SpaServices\Application\GetServices\GetAllServicesQuery;
use App\SpaServices\Application\GetServices\GetAllServicesResponse;
use App\SpaServices\Domain\Exceptions\ServicesNotExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Infrastructure\Symfony\ApiController;


final class GetServicesController extends ApiController
{
    public function __invoke(Request $request): Response
    {

        /** @var GetAllServicesResponse $response */
        $response = $this->ask(new GetAllServicesQuery());

        return $this->successResponse(Response::HTTP_OK, $response->services());
    }


    protected function exceptions(): array
    {
        return [
            ServicesNotExistsException::class => Response::HTTP_NOT_FOUND
        ];
    }
}
