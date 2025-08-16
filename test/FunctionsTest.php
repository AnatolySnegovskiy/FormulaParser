<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Test;

use CarrionGrow\FormulaParser\Exceptions\FormulaParserException;
use CarrionGrow\FormulaParser\Functions\Abs;
use CarrionGrow\FormulaParser\Functions\Add;
use CarrionGrow\FormulaParser\Functions\Cos;
use CarrionGrow\FormulaParser\Functions\Degree;
use CarrionGrow\FormulaParser\Functions\Divide;
use CarrionGrow\FormulaParser\Functions\Exp;
use CarrionGrow\FormulaParser\Functions\FunctionRegistry;
use CarrionGrow\FormulaParser\Functions\Log;
use CarrionGrow\FormulaParser\Functions\Multiply;
use CarrionGrow\FormulaParser\Functions\Sin;
use CarrionGrow\FormulaParser\Functions\Sqrt;
use CarrionGrow\FormulaParser\Functions\Subtract;
use CarrionGrow\FormulaParser\Functions\Tan;
use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function testFactoryCreatesCorrectInstances(): void
    {
        $this->assertInstanceOf(Add::class, FunctionRegistry::create('+'));
        $this->assertInstanceOf(Subtract::class, FunctionRegistry::create('-'));
        $this->assertInstanceOf(Multiply::class, FunctionRegistry::create('*'));
        $this->assertInstanceOf(Divide::class, FunctionRegistry::create('/'));
    }

    public function testAllFunctionCalculations(): void
    {
        $this->assertEquals(5, (new Add('+'))->calculate(2, 3));
        $this->assertEquals(-1, (new Subtract('-'))->calculate(2, 3));
        $this->assertEquals(6, (new Multiply('*'))->calculate(2, 3));
        $this->assertEquals(2, (new Divide('/'))->calculate(6, 3));
        $this->assertEquals(8, (new Degree('^'))->calculate(2, 3));
        $this->assertEquals(sin(deg2rad(2)), (new Sin('sin'))->calculate(2, 1));
        $this->assertEquals(cos(deg2rad(2)) * 3, (new Cos('cos'))->calculate(2, 3));
        $this->assertEquals(tan(deg2rad(2)) * 3, (new Tan('tan'))->calculate(2, 3));
        $this->assertEquals(abs(-2), (new Abs('abs'))->calculate(-2, 1));
        $this->assertEquals(log(2) * 3, (new Log('log'))->calculate(2, 3));
        $this->assertEquals(exp(2) * 3, (new Exp('exp'))->calculate(2, 3));
        $this->assertEquals(sqrt(8 * 2), (new Sqrt('sqrt'))->calculate(2, 8));
    }

    public function testFunctionGetSymbol(): void
    {
        $add = new Add('+');
        $this->assertEquals('+', $add->getSymbol());
    }

    public function testDivideByZeroThrows(): void
    {
        $this->expectException(FormulaParserException::class);
        (new Divide('/'))->calculate(1, 0);
    }

    public function testCreateUnknownFunctionThrowsException(): void
    {
        $this->expectException(FormulaParserException::class);
        FunctionRegistry::create('%');
    }
}
