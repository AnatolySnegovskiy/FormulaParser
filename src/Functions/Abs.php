<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Abs extends AbstractFunction
{
    public function calculate(float $left, float $right): float
    {
        return abs($left);
    }
}
