<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Log extends AbstractFunction
{
    public function calculate(float $left, float $right): float
    {
        return $right * log($left);
    }
}
