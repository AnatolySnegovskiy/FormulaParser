<?php

namespace CarrionGrow\FormulaParser\Functions;

class Tan extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return $right * tan(deg2rad($left));
    }
}