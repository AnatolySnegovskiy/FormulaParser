<?php

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserTest extends TestCase
{
    public function testParseAndCalculateMultiply()
    {
        $parser = new FormulaParser();
        $parser->setFormula('test1 * test2');
        $counter = 1000;

        while ($counter != 0) {
            $first = rand(1, getrandmax()) / getrandmax();
            $second = rand(1, getrandmax()) / getrandmax();
            $parser->setVariables(['test1' => $first, 'test2' => $second]);
            $this->assertEquals($parser->calculate(), $first * $second);
            $counter--;
        }
    }


    public function testParseAndCalculateDivide()
    {
        $parser = new FormulaParser();
        $parser->setFormula('test1 / test2');
        $counter = 1000;

        while ($counter != 0) {
            $first = rand(1, getrandmax()) / getrandmax();
            $second = rand(1, getrandmax()) / getrandmax();
            $parser->setVariables(['test1' => $first, 'test2' => $second]);
            $this->assertEquals($parser->calculate(), $first / $second);
            $counter--;
        }
    }

    public function testParseAndCalculateAdd()
    {
        $parser = new FormulaParser();
        $parser->setFormula('test1 + test2');
        $counter = 1000;

        while ($counter != 0) {
            $first = rand(1, getrandmax()) / getrandmax();
            $second = rand(1, getrandmax()) / getrandmax();
            $parser->setVariables(['test1' => $first, 'test2' => $second]);
            $this->assertEquals($parser->calculate(), $first + $second);
            $counter--;
        }
    }

    public function testParseAndCalculateSubtract()
    {
        $parser = new FormulaParser();
        $parser->setFormula('test1 - test2');
        $counter = 1000;

        while ($counter != 0) {
            $first = rand(1, getrandmax()) / getrandmax();
            $second = rand(1, getrandmax()) / getrandmax();
            $parser->setVariables(['test1' => $first, 'test2' => $second]);
            $this->assertEquals($parser->calculate(), $first - $second);
            $counter--;
        }
    }

    public function testParseAndCalculateFunction()
    {
        $parser = new FormulaParser();
        $parser->setFormula('sin(test1) - cos(test2) * tan(test3) / exp(test4) + abs(test5) - log(test6) * sqrt(test7)');
        $counter = 1000;

        while ($counter != 0) {
            $test1 = rand(1, getrandmax()) / getrandmax();
            $test2 = rand(1, getrandmax()) / getrandmax();
            $test3 = rand(1, getrandmax()) / getrandmax();
            $test4 = rand(1, getrandmax()) / getrandmax();
            $test5 = rand(1, getrandmax()) / getrandmax();
            $test6 = rand(1, getrandmax()) / getrandmax();
            $test7 = rand(1, getrandmax()) / getrandmax();

            $parser->setVariables(['test1' => $test1, 'test2' => $test2, 'test3' => $test3, 'test4' => $test4, 'test5' => $test5, 'test6' => $test6, 'test7' => $test7]);
            $this->assertEquals($parser->calculate(), (sin(deg2rad($test1)) - cos(deg2rad($test2)) * tan(deg2rad($test3)) / exp($test4) + abs($test5) - log($test6) * sqrt($test7)));
            $counter--;
        }
    }

    public function testParseAndCalculateFullInAll()
    {
        $parser = new FormulaParser();
        $parser->setFormula('(test1 ^ test2) + sin(test1) - cos(test2) * (cos(test2) - tan(test3) * test4) - (test2 + test3 / test4 * test1 - test2) + tan(test3) / exp(test4) + abs(test5) - log(test6) * sqrt(test7)');
        $counter = 1000;

        while ($counter != 0) {
            $test1 = rand(1, getrandmax()) / getrandmax();
            $test2 = rand(1, getrandmax()) / getrandmax();
            $test3 = rand(1, getrandmax()) / getrandmax();
            $test4 = rand(1, getrandmax()) / getrandmax();
            $test5 = rand(1, getrandmax()) / getrandmax();
            $test6 = rand(1, getrandmax()) / getrandmax();
            $test7 = rand(1, getrandmax()) / getrandmax();

            $parser->setVariables(['test1' => $test1, 'test2' => $test2, 'test3' => $test3, 'test4' => $test4, 'test5' => $test5, 'test6' => $test6, 'test7' => $test7]);
            $this->assertEquals($parser->calculate(),
                (($test1 ** $test2) + sin(deg2rad($test1)) - cos(deg2rad($test2)) * (cos(deg2rad($test2)) - tan(deg2rad($test3)) * $test4) - ($test2 + $test3 / $test4 * $test1 - $test2) + tan(deg2rad($test3)) / exp($test4) + abs($test5) - log($test6) * sqrt($test7))
            );
            $counter--;
        }
    }
}
