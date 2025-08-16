<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Exceptions\FormulaParserException;
use CarrionGrow\FormulaParser\Functions\FunctionInterface;
use CarrionGrow\FormulaParser\Functions\FunctionRegistry;

class FormulaParser
{
    /**
     * @var ExpressionNode[]
     */
    private $treeNodes = [];

    /**
     * @var ExpressionNode[]
     */
    private $variableNodes = [];

    /**
     * @var ExpressionNode|null
     */
    private $lastNode = null;

    public function getConfig(): ParserConfig
    {
        return ParserConfig::getInstance();
    }

    /**
     * @throws FormulaParserException
     */
    public function setFormula(string $formula): void
    {
        $this->parseFormula($formula);
        $this->lastNode = $this->treeNodes[$this->getLastKey()];
    }

    public function setVariables(array $variables): void
    {
        foreach ($this->variableNodes as $key => $variable) {
            if (isset($variables[$key])) {
                $variable->setResult((float) $variables[$key]);
            }
        }
    }

    /**
     * @throws FormulaParserException
     */
    public function calculate(): float
    {
        if ($this->lastNode === null) {
            throw new FormulaParserException('Formula is not set');
        }

        return $this->lastNode->getResult();
    }

    /**
     * @throws FormulaParserException
     */
    private function parseFormula(string $formula): string
    {
        if ($formula === '') {
            throw new FormulaParserException('Empty Formula');
        }

        $formula = $this->functionParsing($formula);
        $formula = $this->bracketsParsing($formula);

        /** @var ExpressionNode[] $numericList */
        $numericList = [];
        $numeric = '';
        $firstItem = true;
        $charList = str_split($formula);
        /** @var FunctionInterface|null $function */
        $function = null;

        while (($char = array_shift($charList)) !== null) {
            if (((isset($function) || $firstItem) && $char === '-') || preg_match('/[a-z\.0-9_]/ui', $char)) {
                $numeric .= $char;
            }

            if (
                (empty($charList) || in_array($char, [' ', '+', '-', '*', '/', '^']))
                && !empty($numeric)
                && $numeric !== '-'
            ) {
                if (strpos($numeric, 'pi') !== false) {
                    $numeric = str_replace('pi', (string) M_PI, $numeric);
                }

                $keyNumber = is_numeric($numeric) ? $numeric . '_' . count($this->treeNodes) : $numeric;

                if (!isset($this->treeNodes[$keyNumber])) {
                    $this->treeNodes[$keyNumber] = ExpressionNode::createFromNumber((float) $numeric);

                    if (!is_numeric($numeric)) {
                        $this->variableNodes[$keyNumber] = $this->treeNodes[$keyNumber];
                    }
                }

                $numericList[] = $this->treeNodes[$keyNumber];
                $numeric = '';
            }

            if (count($numericList) % 2 === 0 && $function !== null) {
                $numericList[] = $this->makeTree($numericList, $function);
                $function = null;
            } elseif (isset(FunctionRegistry::$map[$char]) && $function === null && !$firstItem) {
                $function = FunctionRegistry::create($char);
            }

            $firstItem = false;
        }

        return $this->getLastKey();
    }

    /**
     * @param ExpressionNode[]  $numericList
     * @param FunctionInterface $function
     *
     * @throws FormulaParserException
     */
    private function makeTree(array $numericList, FunctionInterface $function): ExpressionNode
    {
        $second = array_pop($numericList);
        $first = array_pop($numericList);

        if ($first === null || $second === null) {
            throw new FormulaParserException('Numeric list must contain two operands');
        }

        $right = $first->getRightNode();

        if (in_array($function->getSymbol(), ['*', '/'], true) && $right !== null) {
            $node = ExpressionNode::createFromOperands($right, $function, $second);
            $first->setRightNode($node);
            $node = $first;
        } else {
            $node = ExpressionNode::createFromOperands($first, $function, $second);
        }

        return $this->treeNodes['nodeKey' . count($this->treeNodes)] = $node;
    }

    /**
     * @return string
     * @throws FormulaParserException
     */
    private function getLastKey(): string
    {
        $keys = array_keys($this->treeNodes);
        $lastKey = end($keys);

        if ($lastKey === false) {
            throw new FormulaParserException('Tree is empty');
        }

        return (string) $lastKey;
    }

    /**
     * @throws FormulaParserException
     */
    private function functionParsing(string $formula): string
    {
        preg_match_all('/-?(sqrt|abs|sin|cos|tan|log|exp)\(.+?\)/ui', $formula, $matches);
        $fullMatches = $matches[0];
        $names = $matches[1];

        foreach ($names as $index => $name) {
            $full = $fullMatches[$index];
            $hasLeadingMinus = strpos($full, '-' . $name) === 0;
            $argument = trim(str_replace(['-' . $name, $name], '', $full), '()');

            $key = $this->parseFormula($argument);

            if (!isset($this->treeNodes[$key])) {
                throw new FormulaParserException('Unable to parse function argument');
            }

            $node = $this->treeNodes[$key];
            $keyNode = 'function_' . $name . '_' . $index;
            $this->treeNodes[$keyNode] = ExpressionNode::createFromOperands(
                $node,
                FunctionRegistry::create($name),
                ExpressionNode::createFromNumber($hasLeadingMinus ? -1 : 1)
            );

            $formula = str_replace($full, $keyNode, $formula);
        }

        return $formula;
    }

    /**
     * @throws FormulaParserException
     */
    private function bracketsParsing(string $formula): string
    {
        preg_match_all('/([^a-z]|^)(\((.+?)?\)+)/ui', $formula, $result);
        $result = $result[2];

        foreach ($result as $item) {
            $formula = str_replace($item, $this->parseFormula(trim($item, '()')), $formula);
        }

        return $formula;
    }
}
