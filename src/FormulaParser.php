<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionFactory;
use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class FormulaParser
{
    /** @var TreeNode[] */
    private $treeNodes = [];
    /** @var array */
    private $calculatedTree;

    /**
     * @param string $formula
     * @return void
     */
    public function setFormula(string $formula)
    {
        $this->parseFormula($formula);
    }

    /**
     * @param array $variables
     * @return void
     */
    public function setVariables(array $variables)
    {
        $this->calculatedTree = $this->treeNodes;

        foreach ($variables as $key => $variable) {
            if (isset($this->calculatedTree[$key])) {
                $this->calculatedTree[$key]->setResult($variable);
            }
        }
    }

    /**
     * @return mixed
     */
    public function calculate()
    {
        $lastNode = array_pop($this->calculatedTree);

        if (empty($lastNode)) {
            return 0;
        }

        return $lastNode->getResult();
    }

    /**
     * @param string $formula
     * @return string
     */
    private function parseFormula(string $formula): string
    {
        preg_match_all('/-?(sqrt|abs|sin|cos|tan|log|exp)\(.+?\)/ui', $formula, $result);
        $functionNumberList = $result[0];
        $functionList = $result[1];

        foreach ($functionList as $key => $item) {
            $formulaInFunction = trim(str_replace($item, '', $functionNumberList[$key]), '()');
            $minus = false;

            if (strpos($formulaInFunction, '-') !== false) {
                $minus = true;
            }

            $number = $this->treeNodes[$this->parseFormula($formulaInFunction)];
            $keyNode = 'function_' . $item . '_' . $key;
            $this->treeNodes[$keyNode] = TreeNode::newNode($number, FunctionFactory::make($item), TreeNode::newNumber($minus ? -1 : 1));

            $formula = str_replace($functionNumberList[$key], $keyNode, $formula);
        }

        preg_match_all('/([^a-z]|^)(\((.+?)?\)+)/ui', $formula, $result);
        $result = $result[2];

        foreach ($result as $item) {
            $formula = str_replace($item, $this->parseFormula(trim($item, '()')), $formula);
        }

        /** @var TreeNode[] $numericList */
        $numericList = [];
        $numeric = '';
        $charList = str_split($formula);
        $firstItem = true;

        while (($char = array_shift($charList)) != null) {
            if (((isset($function) || $firstItem) && $char == '-') || preg_match('/[a-z\.0-9\_]/ui', $char)) {
                $numeric .= $char;
            }

            if ((empty($charList) || in_array($char, [' ', '+', '-', '*', '/'])) && !empty($numeric) && $numeric != '-') {
                if (strpos($numeric, 'pi') !== false) {
                    $numeric = str_replace('pi', M_PI, $numeric);
                }

                $keyNumber = is_numeric($numeric) ? $numeric . '_' . count($this->treeNodes) : $numeric;

                if (!isset($this->treeNodes[$keyNumber])) {
                    $this->treeNodes[$keyNumber] = TreeNode::newNumber($numeric);
                }

                $numericList[] = $this->treeNodes[$keyNumber];
                $numeric = '';
            }

            if (count($numericList) % 2 == 0 && !empty($function)) {
                $numericList[] = $this->makeTree($numericList, $function);
                unset($function);
            } elseif (isset(FunctionFactory::$map[$char]) && empty($function) && !$firstItem) {
                $function = FunctionFactory::make($char);
            }

            $firstItem = false;
        }

        return array_keys($this->treeNodes)[count($this->treeNodes) - 1];
    }

    /**
     * @param TreeNode[] $numericList
     * @param FunctionInterface $function
     * @return TreeNode
     */
    private function makeTree(array $numericList, FunctionInterface $function): TreeNode
    {
        $second = array_pop($numericList);
        $first = array_pop($numericList);

        if (in_array($function->getKey(), ['*', '/']) && $first->getRight() !== null) {
            $node = TreeNode::newNode($first->getRight(), $function, $second);
            $first->setRight($node);
            $node = $first;
        } else {
            $node = TreeNode::newNode($first, $function, $second);
        }

        return $this->treeNodes['nodeKey' . count($this->treeNodes)] = $node;
    }
}