<?php
declare(strict_types=1);

namespace App\Domains\Transfer\Calculation;

use App\Domains\Transfer\Calculation\Strategy\CalculationStrategyInterface;
use App\Domains\Transfer\Models\Account;
use BcMath\Number;

class Calculator
{
    public CalculationStrategyInterface $strategy {
        set(CalculationStrategyInterface $strategy) {
            $this->strategy = $strategy;
        }
    }

    public function calculate(Account $account, string $amount): string
    {
        $result = $this->strategy->calculate($account, $amount);

        return $result->value;
    }

}