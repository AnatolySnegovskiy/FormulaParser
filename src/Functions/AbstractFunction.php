<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

abstract class AbstractFunction implements FunctionInterface
{
    /**
     * @var string
     */
    private $symbol;

    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
