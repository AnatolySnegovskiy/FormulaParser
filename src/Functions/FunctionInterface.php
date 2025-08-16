<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

interface FunctionInterface
{
    public function calculate(float $left, float $right): float;

    public function getSymbol(): string;
}
