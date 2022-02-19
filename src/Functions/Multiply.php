<?php

namespace CarrionGrow\FormulaParser\Functions;

class Multiply extends FunctionAbstract
{
    public function calculate($left, $right)
    {
        return $left * $right;
    }
}