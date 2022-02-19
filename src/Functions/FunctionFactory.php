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
            'cos' => Cos::class
        ];

    /**
     * @param string $function
     * @return FunctionInterface
     */
    public static function make(string $function): FunctionInterface
    {
        return new self::$map[$function]($function);
    }
}