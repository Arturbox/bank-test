<?php
declare(strict_types=1);

namespace App\Domains\Auth\Dto;

use App\Domains\Auth\Requests\UpdateRequest;

class UpdateDto
{

    private string $name;
    private string $email;
    private int $age;


    public function __construct(UpdateRequest $request)
    {
        $this->
        setName($request->input('name'))->
        setEmail($request->input('email'))->
        setAge($request->input('age'));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

}
