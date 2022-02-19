<?php

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

class FormulaParserTest extends TestCase
{
    public function testParseAndCulculate()
    {
        $parser = new FormulaParser();
        $parser->setFormula('10 * 2 * (45 - 24) + 10 + (20 + 28) + (1 * 5) + 19 + 2 * 10 / 1.76 * 5 / 4');
        var_dump($parser->calculate());
    }
}
