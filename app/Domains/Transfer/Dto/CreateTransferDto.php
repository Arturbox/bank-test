<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Dto;

use App\Domains\Transfer\Requests\CreateRequest;
use BcMath\Number;

class CreateTransferDto
{

    private int $fromAccountId;
    private int $toAccountId;
    private string $amount;

    public function __construct(CreateRequest $request)
    {
        $this->
        setFromAccountId($request->input('from_account_id'))->
        setToAccountId($request->input('to_account_id'))->
        setAmount($request->input('amount'));
    }

    public function getFromAccountId(): int
    {
        return $this->fromAccountId;
    }

    public function setFromAccountId(int $fromAccountId): self
    {
        $this->fromAccountId = $fromAccountId;

        return $this;
    }

    public function getToAccountId(): int
    {
        return $this->toAccountId;
    }

    public function setToAccountId(int $toAccountId): self
    {
        $this->toAccountId = $toAccountId;

        return $this;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

}