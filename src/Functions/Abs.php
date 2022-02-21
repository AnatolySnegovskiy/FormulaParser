<?php

namespace CarrionGrow\FormulaParser\Functions;

class Abs extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return abs($left);
    }
}