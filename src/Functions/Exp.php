<?php

namespace CarrionGrow\FormulaParser\Functions;

class Exp extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return $right * exp($left);
    }
}