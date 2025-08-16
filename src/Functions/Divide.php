<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

use CarrionGrow\FormulaParser\ParserConfig;

class Divide extends AbstractFunction
{
    /**
     * @throws \Exception
     */
    public function calculate(float $left, float $right): float
    {
        if (empty($right) && ParserConfig::getInstance()->isSkipError()) {
            return 0;
        }

        if (empty($right)) {
            throw new \Exception('Divide by zero');
        }

        return $left / $right;
    }
}
