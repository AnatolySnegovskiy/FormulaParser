<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserTest extends TestCase
{
    public function testGetConfig(): void
    {
        $parser = new FormulaParser();

        $this->assertEquals(Config::getInstance(), $parser->getConfig());
    }

    public function testParseAndCalculateMultiply(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('a * b');
        $parser->setVariables(['a' => 2, 'b' => 3]);
        $this->assertEquals(6.0, $parser->calculate());
    }

    public function testParseAndCalculateDivide(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('a / b');
        $parser->setVariables(['a' => 10, 'b' => 2]);
        $this->assertEquals(5.0, $parser->calculate());
    }

    public function testParseAndCalculateAdd(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('a + b');
        $parser->setVariables(['a' => 4, 'b' => 5]);
        $this->assertEquals(9.0, $parser->calculate());
    }

    public function testParseAndCalculateSubtract(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('a - b');
        $parser->setVariables(['a' => 7, 'b' => 2]);
        $this->assertEquals(5.0, $parser->calculate());
    }

    public function testParseAndCalculateFunction(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula('sin(a) - cos(b) * tan(c) / exp(d) + abs(e) - log(f) * sqrt(g)');

        $vars = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => -5, 'f' => 6, 'g' => 7];
        $parser->setVariables($vars);

        $expected = sin(deg2rad(1)) - cos(deg2rad(2)) * tan(deg2rad(3)) / exp(4) + abs(-5) - log(6) * sqrt(7);
        $this->assertEquals($expected, $parser->calculate());
    }

    public function testParseAndCalculateFullInAll(): void
    {
        $parser = new FormulaParser();
        $parser->setFormula(
            '(a ^ b) + sin(a) - cos(b) * (cos(b) - tan(c) * d) - '
            . '(b + c / d * a - b) + tan(c) / exp(d) + abs(e) - log(f) * sqrt(g)'
        );

        $vars = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => -5, 'f' => 6, 'g' => 7];
        $parser->setVariables($vars);
        $expected = (1 ** 2) + sin(deg2rad(1)) - cos(deg2rad(2))
            * (cos(deg2rad(2)) - tan(deg2rad(3)) * 4)
            - (2 + 3 / 4 * 1 - 2)
            + tan(deg2rad(3)) / exp(4)
            + abs(-5)
            - log(6) * sqrt(7);
        $this->assertEquals($expected, $parser->calculate());
    }
}
