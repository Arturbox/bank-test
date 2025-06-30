<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Calculation\Strategy;

use App\Domains\Transfer\Models\Account;
use BcMath\Number;

class SubAmountToAccountStrategy implements CalculationStrategyInterface
{
    public function calculate(Account $account, string $amount): Number
    {
        return new Number($account->balance)->sub($amount);
    }
}