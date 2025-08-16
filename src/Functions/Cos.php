<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Cos extends AbstractFunction
{
    public function calculate(float $left, float $right): float
    {
        return $right * cos(deg2rad($left));
    }
}
