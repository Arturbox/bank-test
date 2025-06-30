<?php
declare(strict_types=1);

namespace App\Domains\Auth\Dto;

use App\Domains\Auth\Requests\LoginRequest;

class LoginDto
{

    private string $email;
    private string $password;


    public function __construct(LoginRequest $request)
    {
        $this->
        setEmail($request->input('email'))->
        setPassword($request->input('password'));
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


}
