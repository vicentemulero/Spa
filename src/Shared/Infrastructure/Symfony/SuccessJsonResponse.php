<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;

final class SuccessJsonResponse
{
    public static function create($statusCode, $result = null, $header = [], $json = false)
    {
        return new JsonResponse(
            [
                'status' => 'success',
                'result' => $result
            ],
            $statusCode,
            $header,
            $json
        );
    }
}
