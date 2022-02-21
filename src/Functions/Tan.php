<?php

namespace CarrionGrow\FormulaParser\Functions;

class Tan extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return $right * tan(deg2rad($left));
    }
}