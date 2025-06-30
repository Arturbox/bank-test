<?php
declare(strict_types=1);

namespace App\Domains\Auth;

use App\Domains\Auth\Dto\LoginDto;
use App\Domains\Auth\Dto\UpdateDto;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Repositories\AuthRepository;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Hash;

readonly class AuthService
{

    public function __construct(private AuthRepository $authRepository)
    {
    }

    public function login(LoginDto $dto)
    {

        $user = $this->authRepository->findByEmail($dto->getEmail());
        if (!$user || !Hash::check($dto->getPassword(), $user->password)) {
            return null;
        }

        return User::query()->where('email', $dto->getEmail())->first();
    }

    public function update(UpdateDto $dto): User
    {
        try {
            $this->authRepository->updateInfo($dto);

            return $this->authRepository->getByEmail($dto->getEmail());

        } catch (RepositoryException $e) {
            throw new ServiceException($e->getMessage(), $e->getCode(), $e);
        }
    }

}
