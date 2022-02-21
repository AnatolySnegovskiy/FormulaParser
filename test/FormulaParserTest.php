<?php

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserTest extends TestCase
{
    public function testParseAndCulculate()
    {
        $parser = new FormulaParser();
        $parser->setFormula('test1 * test2');

        $counter = 2;

        while ($counter != 0) {
            $parser->setVariables(['test1' => 2, 'test2' => 1]);
            $parser->calculate();
            $counter--;
        }
    }
}
