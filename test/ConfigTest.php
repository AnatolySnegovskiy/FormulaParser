<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser\Test;

use CarrionGrow\FormulaParser\Config;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the Config singleton.
 */
class ConfigTest extends TestCase
{
    /**
     * getInstance should always return the same object.
     */
    public function testGetInstanceReturnsSameObject(): void
    {
        $first = Config::getInstance();
        $second = Config::getInstance();
        $this->assertSame($first, $second);
    }

    /**
     * Skip error flag must be configurable.
     */
    public function testSetAndGetSkipError(): void
    {
        $config = Config::getInstance();
        $config->setSkipError(true);
        $this->assertTrue($config->isSkipError());
        // reset to default for other tests
        $config->setSkipError(false);
    }
}
