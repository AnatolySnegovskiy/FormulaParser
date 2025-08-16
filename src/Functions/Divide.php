<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

use CarrionGrow\FormulaParser\Exceptions\FormulaParserException;
use CarrionGrow\FormulaParser\Config;

class Divide extends AbstractFunction
{
    /**
     * @throws FormulaParserException
     */
    public function calculate(float $left, float $right): float
    {
        if (empty($right) && Config::getInstance()->isSkipError()) {
            return 0;
        }

        if (empty($right)) {
            throw new FormulaParserException('Divide by zero');
        }

        return $left / $right;
    }
}
