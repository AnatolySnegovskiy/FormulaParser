<?php

namespace CarrionGrow\FormulaParser\Functions;

class Sin extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return $right * sin(deg2rad($left));
    }
}