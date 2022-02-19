<?php

namespace CarrionGrow\FormulaParser\Functions;

class FunctionFactory
{
    public static $map =
        [
            '*' => Multiply::class,
            '/' => Divide::class,
            '+' => Add::class,
            '-' => Subtract::class,
        ];

    /**
     * @param string $function
     * @return FunctionInterface
     */
    public static function factory(string $function): FunctionInterface
    {
        return new self::$map[$function]($function);
    }
}