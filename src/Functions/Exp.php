<?php

namespace CarrionGrow\FormulaParser\Functions;

class Exp extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return $right * exp($left);
    }
}