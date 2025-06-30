<?php
declare(strict_types=1);

namespace App\Domains\Auth\Repositories;

use App\Common\BaseRepository;
use App\Domains\Auth\Dto\UpdateDto;
use App\Domains\Auth\Models\User;
use App\Exceptions\RepositoryException;
use Throwable;

class AuthRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->builder->where('email', $email)->first();
    }

    public function getByEmail(string $email): User
    {
        return $this->findByEmail($email);
    }

    public function updateInfo(UpdateDto $dto): void
    {
        try {
            $this->builder->where('email', $dto->getEmail())->update([
                'name' => $dto->getName(),
                'email' => $dto->getEmail(),
                'age' => $dto->getAge(),
            ]);
        } catch (Throwable $exception) {
            throw new RepositoryException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}
