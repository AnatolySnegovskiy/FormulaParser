<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use PHPUnit\Framework\TestCase;

/**
 * Tests for the ParserConfig singleton.
*/
class ParserConfigTest extends TestCase
{
    /**
     * getInstance should always return the same object.
     */
    public function testGetInstanceReturnsSameObject(): void
    {
        $first = ParserConfig::getInstance();
        $second = ParserConfig::getInstance();
        $this->assertSame($first, $second);
    }

    /**
     * Skip error flag must be configurable.
     */
    public function testSetAndGetSkipError(): void
    {
        $config = ParserConfig::getInstance();
        $config->setSkipError(true);
        $this->assertTrue($config->isSkipError());
        // reset to default for other tests
        $config->setSkipError(false);
    }
}
