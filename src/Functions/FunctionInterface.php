<?php

namespace CarrionGrow\FormulaParser\Functions;

interface FunctionInterface
{
    public function calculate(float $left, float $right): float;
    public function getKey();
}