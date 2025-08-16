<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class TreeNode
{
    /**
     * @var FunctionInterface|null
     */
    private $function;

    /**
     * @var TreeNode|null
     */
    private $right;

    /**
     * @var TreeNode|null
     */
    private $left;

    /**
     * @var float
     */
    private $result = 0.0;

    public function getFunction(): ?FunctionInterface
    {
        return $this->function;
    }

    public function setFunction(?FunctionInterface $function): self
    {
        $this->function = $function;

        return $this;
    }

    public function getRight(): ?TreeNode
    {
        return $this->right;
    }

    public function setRight(?TreeNode $right): self
    {
        $this->right = $right;

        return $this;
    }

    public function getLeft(): ?TreeNode
    {
        return $this->left;
    }

    public function setLeft(?TreeNode $left): self
    {
        $this->left = $left;

        return $this;
    }

    public function setResult(float $result): void
    {
        $this->result = $result;
    }

    public function __construct(?TreeNode $left = null, ?FunctionInterface $function = null, ?TreeNode $right = null)
    {
        $this->left = $left;
        $this->function = $function;
        $this->right = $right;
    }

    public static function newNumber(float $number): self
    {
        $node = new self();
        $node->setResult($number);

        return $node;
    }

    public static function newNode(TreeNode $left, FunctionInterface $function, TreeNode $right): self
    {
        return new self($left, $function, $right);
    }

    public function getResult(): float
    {
        if ($this->function !== null && $this->left !== null && $this->right !== null) {
            $this->result = $this->function->calculate($this->left->getResult(), $this->right->getResult());
        }

        return (float) $this->result;
    }
}
