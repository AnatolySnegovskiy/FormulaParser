<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionFactory;
use CarrionGrow\FormulaParser\Functions\FunctionInterface;
use Exception;

class FormulaParser
{
    /**
     * @var TreeNode[]
     */
    private $treeNodes = [];

    /**
     * @var TreeNode[]
     */
    private $variableNodes = [];

    /**
     * @var TreeNode
     */
    private $lastNode;

    public function getConfig(): Config
    {
        return Config::getInstance();
    }

    /**
     * @throws Exception
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
                $variable->result = $variables[$key];
            }
        }
    }

    public function calculate(): float
    {
        return $this->lastNode->getResult();
    }

    /**
     * @throws Exception
     */
    private function parseFormula(string $formula): string
    {
        if (empty($formula)) {
            throw new Exception('Empty Formula');
        }

        $formula = $this->functionParsing($formula);
        $formula = $this->bracketsParsing($formula);

        /** @var TreeNode[] $numericList */
        $numericList = [];
        $numeric = '';
        $firstItem = true;
        $charList = str_split($formula);

        /** @var FunctionInterface|null $function */
        $function = null;

        while (($char = array_shift($charList)) !== null) {
            if ((($function !== null || $firstItem) && $char === '-') || preg_match('/[a-z\.0-9_]/ui', $char)) {
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
                    $this->treeNodes[$keyNumber] = TreeNode::newNumber((float) $numeric);

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
            } elseif (isset(FunctionFactory::$map[$char]) && $function === null && !$firstItem) {
                $function = FunctionFactory::make($char);
            }

            $firstItem = false;
        }

        return $this->getLastKey();
    }

    /**
     * @param TreeNode[]        $numericList
     * @param FunctionInterface $function
     */
    private function makeTree(array $numericList, FunctionInterface $function): TreeNode
    {
        $second = array_pop($numericList);
        $first = array_pop($numericList);

        if (!$second || !$first) {
            throw new \LogicException('Not enough operands to build tree');
        }

        if (in_array($function->getKey(), ['*', '/'], true) && $first->getRight() !== null) {
            $node = TreeNode::newNode($first->getRight(), $function, $second);
            $first->setRight($node);
            $node = $first;
        } else {
            $node = TreeNode::newNode($first, $function, $second);
        }

        return $this->treeNodes['nodeKey' . count($this->treeNodes)] = $node;
    }

    /**
     * @return int|string
     */
    private function getLastKey()
    {
        return array_keys($this->treeNodes)[count($this->treeNodes) - 1];
    }

    /**
     * @throws Exception
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

            $node = $this->treeNodes[$this->parseFormula($argument)];
            $keyNode = 'function_' . $name . '_' . $index;
            $this->treeNodes[$keyNode] = TreeNode::newNode(
                $node,
                FunctionFactory::make($name),
                TreeNode::newNumber($hasLeadingMinus ? -1 : 1)
            );

            $formula = str_replace($full, $keyNode, $formula);
        }

        return $formula;
    }

    /**
     * @throws Exception
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
