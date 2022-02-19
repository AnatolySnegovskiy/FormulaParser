<?php

namespace CarrionGrow\FormulaParser\Functions;

class Cos extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return $right * cos(deg2rad($left));
    }
}