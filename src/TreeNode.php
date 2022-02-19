<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class TreeNode
{
    /** @var FunctionInterface */
    private $function;
    private $right;
    private $left;
    private $result = 0;

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

    public function setResult($result): self
    {
        $this->result = $result;
        return $this;
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
        return (new TreeNode())->setResult($number);
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

    public function getResult()
    {
        if (!empty($this->function)) {
            $this->result = $this->function->calculate($this->left->getResult(), $this->right->getResult());
        }

        return $this->result;
    }
}