<?php

namespace CarrionGrow\FormulaParser\Functions;

class Log extends FunctionAbstract
{

    public function calculate(float $left, float $right): float
    {
        return $right * log($left);
    }
}