<?php
declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyException extends  ConflictHttpException
{
    private const MESSAGE_USER_ALREADY_EXISTS = "User with email %s already exists";

    public static function fromEmail(string $email): self
    {
        throw new self(sprintf(self::MESSAGE_USER_ALREADY_EXISTS, $email));
    }

}