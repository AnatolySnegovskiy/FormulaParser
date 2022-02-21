<?php

namespace CarrionGrow\FormulaParser\Functions;

class Sqrt extends FunctionAbstract
{
    public function calculate($left, $right): float
    {
        return sqrt(($right * $left));
    }
}