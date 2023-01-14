<?php

declare(strict_types=1);

namespace App\Health\Application;

use App\Shared\Domain\Bus\Query\QueryResponse;

class GetHealthResponse implements QueryResponse
{
    private int $status;
    private string $message;

    private function __construct(int $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public static function ofSuccess(string $message): self
    {
        return new self(1, $message);
    }

    public static function ofError(string $message): self
    {
        return new self(-1, $message);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
