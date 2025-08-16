<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

class ParserConfig
{
    /**
     * @var ParserConfig|null
     */
    private static $instance = null;

    /**
     * @var bool
     */
    private $skipError = false;

    private function __construct()
    {
    }

    public static function getInstance(): ParserConfig
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function isSkipError(): bool
    {
        return $this->skipError;
    }

    public function setSkipError(bool $skipError): void
    {
        $this->skipError = $skipError;
    }
}
