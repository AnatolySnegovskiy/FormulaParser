<?php

namespace CarrionGrow\FormulaParser\Functions;

class Divide extends FunctionAbstract
{
    public function calculate($left, $right)
    {
        return $left / $right;
    }
}