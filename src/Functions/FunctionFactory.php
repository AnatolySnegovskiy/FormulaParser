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
            '^' => Degree::class,
            'cos' => Cos::class,
            'sin' => Sin::class,
            'exp' => Exp::class,
            'abs' => Abs::class,
            'log' => Log::class,
            'sqrt' => Sqrt::class,
            'tan' => Tan::class,
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