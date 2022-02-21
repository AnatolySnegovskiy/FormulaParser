<?php

namespace CarrionGrow\FormulaParser\Functions;

class Add extends FunctionAbstract
{
    public function calculate(float $left, float $right): float
    {
        return $left + $right;
    }
}