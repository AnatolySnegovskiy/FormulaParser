<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Multiply extends AbstractFunction
{
    public function calculate(float $left, float $right): float
    {
        return $left * $right;
    }
}
