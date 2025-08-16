<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Add extends FunctionAbstract
{
    public function calculate(float $left, float $right): float
    {
        return $left + $right;
    }
}
