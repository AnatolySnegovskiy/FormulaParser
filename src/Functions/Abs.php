<?php

namespace CarrionGrow\FormulaParser\Functions;

class Abs extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return abs($left);
    }
}