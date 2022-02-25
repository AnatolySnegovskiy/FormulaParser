<?php

namespace CarrionGrow\FormulaParser;

class Config
{
    private static $instance;
    private $skipError = false;

    private function __construct(){}

    public static function getInstance(): Config
    {
        return self::$instance ?? self::$instance = new Config();
    }

    /**
     * @return bool
     */
    public function isSkipError(): bool
    {
        return $this->skipError;
    }

    /**
     * @param bool $skipError
     */
    public function setSkipError(bool $skipError): void
    {
        $this->skipError = $skipError;
    }
}