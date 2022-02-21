<?php

namespace CarrionGrow\FormulaParser\Functions;

class Sqrt extends FunctionAbstract
{
    public function calculate(float $left, float $right): float
    {
        return sqrt(($right * $left));
    }
}