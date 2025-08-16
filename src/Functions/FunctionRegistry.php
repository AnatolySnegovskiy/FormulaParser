<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

use Exception;

class FunctionRegistry
{
    /**
     * @var array<string, class-string<FunctionInterface>>
     */
    public static $map = [
        '*'   => Multiply::class,
        '/'   => Divide::class,
        '+'   => Add::class,
        '-'   => Subtract::class,
        '^'   => Degree::class,
        'cos' => Cos::class,
        'sin' => Sin::class,
        'exp' => Exp::class,
        'abs' => Abs::class,
        'log' => Log::class,
        'sqrt' => Sqrt::class,
        'tan' => Tan::class,
    ];

    /**
     * @throws Exception
     */
    public static function create(string $symbol): FunctionInterface
    {
        if (!isset(self::$map[$symbol])) {
            throw new Exception('Unknown function: ' . $symbol);
        }

        $class = self::$map[$symbol];

        return new $class($symbol);
    }
}
