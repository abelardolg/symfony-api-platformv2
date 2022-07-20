<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exceptions\User\UserNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\OptimisticLockException;

class UserRepository extends BaseRepository
{

    protected static function entityClass(): string
    {
        return User::class;
    }

    public function findOneByEmailOrFail(string $email): User {
        $user = $this->objectRepository->findOneBy(["email" => $email]);

        if(!$user) {
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException|\Doctrine\Persistence\Mapping\MappingException
     */
    public function save(User $user): void {
        $this->saveEntity($user);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException|\Doctrine\Persistence\Mapping\MappingException
     */
    public function remove(User $user): void {
        $this->removeEntity($user);
    }
}