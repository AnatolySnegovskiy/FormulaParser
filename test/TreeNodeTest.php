<?php

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the TreeNode class.
 */
class TreeNodeTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Verify that a numeric node created via newNumber keeps the provided value.
     */
    public function testNewNumberHoldsResult()
    {
        $node = TreeNode::newNumber(10);
        $this->assertSame(10.0, $node->getResult());
    }

    /**
     * Ensure getResult invokes the assigned function with left and right results.
     */
    public function testGetResultUsesFunction()
    {
        $left = TreeNode::newNumber(2);
        $right = TreeNode::newNumber(3);

        $function = Mockery::mock(FunctionInterface::class);
        $function->shouldReceive('calculate')
            ->once()
            ->with(2.0, 3.0)
            ->andReturn(5.0);

        $node = TreeNode::newNode($left, $function, $right);

        $this->assertSame(5.0, $node->getResult());
    }

    /**
     * Cover all getter and setter combinations.
     */
    public function testGettersAndSetters()
    {
        $left = TreeNode::newNumber(1);
        $right = TreeNode::newNumber(2);
        $function = Mockery::mock(FunctionInterface::class);

        $node = new TreeNode();
        $node->setLeft($left)
            ->setRight($right)
            ->setFunction($function)
            ->setResult(3);

        $this->assertSame($left, $node->getLeft());
        $this->assertSame($right, $node->getRight());
        $this->assertSame($function, $node->getFunction());
        $this->assertSame(3.0, $node->getResult());
    }
}
