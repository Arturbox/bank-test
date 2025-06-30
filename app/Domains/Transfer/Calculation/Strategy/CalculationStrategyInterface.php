<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Calculation\Strategy;

use App\Domains\Transfer\Models\Account;
use BcMath\Number;

interface CalculationStrategyInterface
{
    public const int SCALE = 10;

    public function calculate(Account $account, string $amount): Number;

}
