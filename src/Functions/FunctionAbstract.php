<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

abstract class FunctionAbstract implements FunctionInterface
{
    /**
     * @var string
     */
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
