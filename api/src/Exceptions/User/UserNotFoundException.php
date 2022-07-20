<?php
declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{

    private const USER_NOT_FOUND_MESSAGE = "User with email %s not found!";

    public static function fromEmail(string $email): self
    {
        throw new self(sprintf(self::USER_NOT_FOUND_MESSAGE, $email));
    }
}