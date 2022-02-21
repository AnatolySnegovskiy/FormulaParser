<?php

namespace CarrionGrow\FormulaParser\Functions;

class Sin extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return $right * sin(deg2rad($left));
    }
}