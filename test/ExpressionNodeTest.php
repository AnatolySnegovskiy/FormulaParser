<?php

declare(strict_types=1);

namespace CarrionGrow\FormulaParser;

use CarrionGrow\FormulaParser\Functions\FunctionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the ExpressionNode class.
*/
class ExpressionNodeTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * Verify that a numeric node created via createFromNumber keeps the provided value.
     */
    public function testNewNumberHoldsResult(): void
    {
        $node = ExpressionNode::createFromNumber(10);
        $this->assertSame(10.0, $node->getResult());
    }

    /**
     * Ensure getResult invokes the assigned function with left and right results.
     */
    public function testGetResultUsesFunction(): void
    {
        $left = ExpressionNode::createFromNumber(2);
        $right = ExpressionNode::createFromNumber(3);

        $function = Mockery::mock(FunctionInterface::class);
        $function->shouldReceive('calculate')
            ->once()
            ->with(2.0, 3.0)
            ->andReturn(5.0);

        $node = ExpressionNode::createFromOperands($left, $function, $right);

        $this->assertSame(5.0, $node->getResult());
    }

    /**
     * Cover all getter and setter combinations.
     */
    public function testGettersAndSetters(): void
    {
        $left = ExpressionNode::createFromNumber(1);
        $right = ExpressionNode::createFromNumber(2);
        $function = Mockery::mock(FunctionInterface::class);
        $function->shouldReceive('calculate')
            ->once()
            ->with(1.0, 2.0)
            ->andReturn(3.0);

        $node = new ExpressionNode();
        $node->setLeftNode($left)
            ->setRightNode($right)
            ->setOperation($function)
            ->setResult(3);

        $this->assertSame($left, $node->getLeftNode());
        $this->assertSame($right, $node->getRightNode());
        $this->assertSame($function, $node->getOperation());
        $this->assertSame(3.0, $node->getResult());
    }
}
