<?php

namespace CarrionGrow\FormulaParser\Functions;

abstract class FunctionAbstract implements FunctionInterface
{
    private $functionKey;

    public function __construct(string $function)
    {
        $this->functionKey = $function;
    }

    public function getKey(): string
    {
        return $this->functionKey;
    }
}