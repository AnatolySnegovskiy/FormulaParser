<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserEdgeCasesTest extends TestCase
{
    public function testEmptyFormulaThrowsException(): void
    {
        $this->expectException(\Exception::class);
        $parser = new FormulaParser();
        $parser->setFormula('');
    }

    public function testPiConstant(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('pi + 1');
        $parser->setVariables([]);
        $this->assertEqualsWithDelta(M_PI + 1, $parser->calculate(), 1e-12);
    }

    public function testOperatorPrecedence(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('1 + 2 * 3');
        $parser->setVariables([]);
        $this->assertEquals(7.0, $parser->calculate());
    }

    public function testDivideByZeroBehaviour(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('a / b');
        $parser->setVariables(['a' => 1, 'b' => 0]);

        $config = Config::getInstance();
        $config->setSkipError(true);
        $this->assertEquals(0.0, $parser->calculate());

        $config->setSkipError(false);
        $parser->setVariables(['a' => 1, 'b' => 0]);
        $this->expectException(\Exception::class);
        $parser->calculate();
    }

    public function testNegativeFunctionArgument(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('sin(-5)');
        $parser->setVariables([]);
        $this->assertEquals(sin(deg2rad(-5)), $parser->calculate());
    }
}

