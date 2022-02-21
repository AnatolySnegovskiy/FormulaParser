<?php

namespace CarrionGrow\FormulaParser\Functions;

class Subtract extends FunctionAbstract
{
    public function calculate(float $left, float $right): float
    {
        return $left - $right;
    }
}