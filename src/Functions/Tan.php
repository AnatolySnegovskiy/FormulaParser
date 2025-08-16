<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

class Tan extends AbstractFunction
{
    public function calculate(float $left, float $right): float
    {
        return $right * tan(deg2rad($left));
    }
}
