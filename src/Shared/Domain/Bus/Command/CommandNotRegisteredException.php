<?php declare(strict_types=1);

namespace App\Shared\Domain\Bus\Command;

final class CommandNotRegisteredException extends \RuntimeException
{
    private CommandInterface $command;

    public function __construct(CommandInterface $command)
    {
        parent::__construct(sprintf('Command %s not registered', get_class($command)));
        $this->command = $command;
    }
}
