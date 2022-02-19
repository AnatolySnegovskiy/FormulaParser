<?php

namespace CarrionGrow\FormulaParser\Functions;

class Subtract extends FunctionAbstract
{
    public function calculate($left, $right)
    {
        return $left - $right;
    }
}