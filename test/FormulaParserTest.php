<?php

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserTest extends TestCase
{
    public function testParseAndCulculate()
    {
        $parser = new FormulaParser();
        $parser->setFormula('');
        $parser->setVariables(['test1' => 2, 'test2' => 3]);
        var_dump($parser->calculate());
        $parser->setVariables(['test1' => 10, 'test2' => 2]);
        var_dump($parser->calculate());
    }
}
