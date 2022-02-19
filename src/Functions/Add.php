<?php

namespace CarrionGrow\FormulaParser\Functions;

class Add extends FunctionAbstract
{
    public function calculate($left, $right)
    {
        return $left + $right;
    }
}