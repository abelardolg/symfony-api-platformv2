<?php
declare(strict_types=1);

namespace App\Service\Password;

use App\Exceptions\Password\PasswordException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EncoderService
{
    public const MINIMUM_LENGTH = 6;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    public function generateEncodedPassword(UserInterface $user, string $plainPassword): string
    {
        if (self::MINIMUM_LENGTH > strlen($plainPassword)) {
            throw PasswordException::invalidLength(self::MINIMUM_LENGTH);
        }

        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }

    public  function isValidPassword(UserInterface $user, string $currentPassword): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $currentPassword);
    }
}