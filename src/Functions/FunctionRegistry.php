<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Functions;

use CarrionGrow\FormulaParser\Exceptions\FormulaParserException;

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
     * @throws FormulaParserException
     */
    public static function create(string $symbol): FunctionInterface
    {
        if (!isset(self::$map[$symbol])) {
            throw new FormulaParserException('Unknown function: ' . $symbol);
        }

        $class = self::$map[$symbol];

        return new $class($symbol);
    }
}
