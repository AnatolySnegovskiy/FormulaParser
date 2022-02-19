<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionFactory;

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
        $lastKey = '';
        $charList = str_split($formula);
        $prioritet = false;

        while (($char = array_shift($charList)) != null) {
            if (preg_match('/[a-z\.0-9]/ui', $char)) {
                $numeric .= $char;
            }

            if (empty($charList) || $char == ' ' && !empty($numeric)) {
                $keyNumber = is_numeric($numeric) ? $numeric . count($this->treeNodes) : $numeric;

                if (!isset($this->treeNodes[$keyNumber])) {
                    $this->treeNodes[$keyNumber] = TreeNode::newNumber($numeric);
                }

                $numericList[] = $this->treeNodes[$keyNumber];
                $numeric = '';
            }

            if (count($numericList) % 2 == 0 && !empty($functionNode)) {
                $second = array_pop($numericList);
                $first = array_pop($numericList);

                if ($first->getRight() == null) {
                    $prioritet = false;
                }

                if ($prioritet) {
                    $node = TreeNode::newNode($first->getRight(), $functionNode, $second);
                    $first->setRight($node);
                    $node = $first;
                    $prioritet = false;
                } else {
                    $node = TreeNode::newNode($first, $functionNode, $second);
                }

                $lastKey = 'nodeKey' . count($this->treeNodes);
                $numericList[] = $this->treeNodes[$lastKey] = $node;
            }  elseif (isset(FunctionFactory::$map[$char])) {
                $functionNode = FunctionFactory::factory($char);
                if ($char === '*' || $char === '/') {
                    $prioritet = true;
                }
            }
        }

        return $lastKey;
    }
}