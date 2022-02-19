<?php

namespace CarrionGrow\FormulaParser\Functions;

interface FunctionInterface
{
    public function calculate($left, $right);
    public function getKey();
}