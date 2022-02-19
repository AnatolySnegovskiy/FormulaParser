<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionFactory;
use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class FormulaParser
{
    /** @var TreeNode[] */
    private $treeNodes = [];


    public function setFormula(string $formula)
    {
        $this->parseFormula($formula);
    }

    public function calculate()
    {
        $a = array_pop($this->treeNodes)->getResult();
        return $a;
    }

    private function parseFormula(string $formula): string
    {
        var_dump($formula);
        preg_match_all('/([^a-z]|^)(\((.+?)?\)+)/ui', $formula, $result);
        $result = $result[2];

        foreach ($result as $item) {
            $formula = str_replace($item, $this->parseFormula(trim($item, '()')), $formula);
        }

        /** @var TreeNode[] $numericList */
        $numericList = [];
        $numeric = '';
        $charList = str_split($formula);

        while (($char = array_shift($charList)) != null) {
            if (preg_match('/[a-z\.0-9]/ui', $char)) {
                $numeric .= $char;
            }

            if (empty($charList) || $char == ' ' && !empty($numeric)) {
                $keyNumber = is_numeric($numeric) ? $numeric . '_' . count($this->treeNodes) : $numeric;

                if (!isset($this->treeNodes[$keyNumber])) {
                    $this->treeNodes[$keyNumber] = TreeNode::newNumber($numeric);
                }

                $numericList[] = $this->treeNodes[$keyNumber];
                $numeric = '';
            }

            if (count($numericList) % 2 == 0 && !empty($function)) {
                $numericList[] = $this->makeTree($numericList, $function);
            } elseif (isset(FunctionFactory::$map[$char])) {
                $function = FunctionFactory::factory($char);
            }
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