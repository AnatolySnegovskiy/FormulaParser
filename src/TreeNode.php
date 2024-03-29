<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class TreeNode
{
    /** @var FunctionInterface */
    private $function;
    /** @var TreeNode|null  */
    private $right;
    /** @var TreeNode|null  */
    private $left;

    public $result = 0;

#region getter_setter
    /**
     * @return FunctionInterface
     */
    public function getFunction(): ?FunctionInterface
    {
        return $this->function;
    }

    /**
     * @param FunctionInterface|null $function
     * @return $this
     */
    public function setFunction(?FunctionInterface $function): self
    {
        $this->function = $function;
        return $this;
    }

    /**
     * @return TreeNode|null
     */
    public function getRight(): ?TreeNode
    {
        return $this->right;
    }

    /**
     * @param TreeNode|null $right
     * @return $this
     */
    public function setRight(?TreeNode $right): self
    {
        $this->right = $right;
        return $this;
    }

    /**
     * @return TreeNode|null
     */
    public function getLeft(): ?TreeNode
    {
        return $this->left;
    }

    /**
     * @param TreeNode|null $left
     * @return $this
     */
    public function setLeft(?TreeNode $left): self
    {
        $this->left = $left;
        return $this;
    }

    /**
     * @param $result
     * @return void
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
#endregion

    public function __construct(TreeNode $left = null, FunctionInterface $function = null, TreeNode $right = null)
    {
        $this->left = $left;
        $this->function = $function;
        $this->right = $right;
    }


    public static function newNumber($number): self
    {
        $node = new TreeNode();
        $node->setResult($number);

        return $node;
    }

    /**
     * @param TreeNode $left
     * @param FunctionInterface $function
     * @param TreeNode $right
     * @return TreeNode
     */
    public static function newNode(TreeNode $left, FunctionInterface $function, TreeNode $right): self
    {
        return new TreeNode($left, $function, $right);
    }

    public function getResult(): float
    {
        if (!empty($this->function)) {
            $this->result = $this->function->calculate($this->left->getResult(), $this->right->getResult());
        }

        return (float)$this->result;
    }
}