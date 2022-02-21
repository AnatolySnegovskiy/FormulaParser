<?php

namespace CarrionGrow\FormulaParser\Functions;

class Divide extends FunctionAbstract
{
    /**
     * @throws \Exception
     */
    public function calculate($left, $right)
    {
        if ($right == 0) {
            throw new \Exception('Divide by zero');
        }

        return $left / $right;
    }
}