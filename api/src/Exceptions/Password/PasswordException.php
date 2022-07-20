<?php
declare(strict_types=1);

namespace App\Exceptions\Password;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PasswordException extends BadRequestException
{
    private const INVALID_LENGTH_MESSAGE = "Password must be at least %s characters";
    public static function invalidLength(int $minimumLength)
    {
        $invalidLengthMessage = sprintf(self::INVALID_LENGTH_MESSAGE, $minimumLength);
        throw new self($invalidLengthMessage);
    }
}