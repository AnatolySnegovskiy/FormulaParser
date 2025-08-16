<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;

class ExpressionNode
{
    /**
     * @var FunctionInterface|null
     */
    private $operation;

    /**
     * @var ExpressionNode|null
     */
    private $rightNode;

    /**
     * @var ExpressionNode|null
     */
    private $leftNode;

    /**
     * @var float
     */
    private $result = 0.0;

    public function getOperation(): ?FunctionInterface
    {
        return $this->operation;
    }

    public function setOperation(?FunctionInterface $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getRightNode(): ?ExpressionNode
    {
        return $this->rightNode;
    }

    public function setRightNode(?ExpressionNode $right): self
    {
        $this->rightNode = $right;

        return $this;
    }

    public function getLeftNode(): ?ExpressionNode
    {
        return $this->leftNode;
    }

    public function setLeftNode(?ExpressionNode $left): self
    {
        $this->leftNode = $left;

        return $this;
    }

    public function setResult(float $result): void
    {
        $this->result = $result;
    }

    public function __construct(
        ?ExpressionNode $left = null,
        ?FunctionInterface $operation = null,
        ?ExpressionNode $right = null
    ) {
        $this->leftNode = $left;
        $this->operation = $operation;
        $this->rightNode = $right;
    }

    public static function createFromNumber(float $number): self
    {
        $node = new self();
        $node->setResult($number);

        return $node;
    }

    public static function createFromOperands(
        ExpressionNode $left,
        FunctionInterface $operation,
        ExpressionNode $right
    ): self {
        return new self($left, $operation, $right);
    }

    public function getResult(): float
    {
        if ($this->operation !== null && $this->leftNode !== null && $this->rightNode !== null) {
            $this->result = $this->operation->calculate($this->leftNode->getResult(), $this->rightNode->getResult());
        }

        return $this->result;
    }
}
