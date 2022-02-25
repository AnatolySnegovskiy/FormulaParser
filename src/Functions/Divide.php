<?php

namespace CarrionGrow\FormulaParser\Functions;

use CarrionGrow\FormulaParser\Config;

class Divide extends FunctionAbstract
{
    /**
     * @throws \Exception
     */
    public function calculate(float $left, float $right): float
    {
        if (empty($right) && Config::getInstance()->isSkipError()) {
            return 0;
        }

        if (empty($right)) {
            throw new \Exception('Divide by zero');
        }

        return $left / $right;
    }
}