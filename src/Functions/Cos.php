<?php

namespace CarrionGrow\FormulaParser\Functions;

class Cos extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return $right * cos(deg2rad($left));
    }
}