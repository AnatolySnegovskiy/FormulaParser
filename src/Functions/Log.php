<?php

namespace CarrionGrow\FormulaParser\Functions;

class Log extends FunctionAbstract
{

    public function calculate($left, $right)
    {
        return $right * log($left);
    }
}