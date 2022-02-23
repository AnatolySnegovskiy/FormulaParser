<?php

namespace CarrionGrow\FormulaParser\Functions;

class Degree extends FunctionAbstract
{
    public function calculate(float $left, float $right): float
    {
        return $left ** $right;
    }
}