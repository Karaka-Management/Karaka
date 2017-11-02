<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\Stdlib\Graph;

/**
 * Tree class.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 *
 * @todo       : there is a bug with Hungary ibans since they have two k (checksums) in their definition
 */
class BinaryTree extends Tree
{
    public static function invert($list) : BinaryTree
    {
        if (empty($list->getNodes())) {
            return $list;
        }

        $left = $list->getLeft();
        $list->setLeft($list->invert($list->nodes[1]));
        $list->setRight($list->invert($left));

        return $list;  
    }

    /**
     * Get left node of a node.
     *
     * @param Node $base Tree node
     *
     * @return Node Left node
     *
     * @since  1.0.0
     */
    public function getLeft(Node $base)
    {
        $neighbors = $base->getNeighbors($base);

        // todo: index can be wrong, see setLeft/setRight
        return $neighbors[0] ?? null;
    }

    /**
     * Get right node of a node.
     *
     * @param Node $base Tree node
     *
     * @return Node Right node
     *
     * @since  1.0.0
     */
    public function getRight(Node $base)
    {
        $neighbors = $this->getNeighbors($base);

        // todo: index can be wrong, see setLeft/setRight
        return $neighbors[1] ?? null;
    }

    /**
     * Set left node of node.
     *
     * @param Node $base Base node
     * @param Node $left Left node
     *
     * @return BinaryTree
     *
     * @since  1.0.0
     */
    public function setLeft(Node $base, Node $left) : BinaryTree
    {
        if ($this->getLeft($base) === null) {
            $this->addNodeRelative($base, $left);
            // todo: doesn't know that this is left
            // todo: maybe need to add numerics to edges?
        } else {
            // todo: replace node
        }

        return $this;
    }

    /**
     * Set right node of node.
     *
     * @param Node $base Base node
     * @param Node $right Right node
     *
     * @return BinaryTree
     *
     * @since  1.0.0
     */
    public function setRight(Node $base, Node $right)  /* : void */
    {
        if ($this->getRight($base) === null) {
            $this->addNodeRelative($base, $right);
            // todo: doesn't know that this is right
            // todo: maybe need to add numerics to edges?
        } else {
            // todo: replace node
        }
    }

    /**
     * Perform action on tree in in-order.
     *
     * @param Node $node Tree node
     * @param \Closure $callback Task to perform on node
     *
     * @since  1.0.0
     */
    public function inOrder(Node $node, \Closure $callback) 
    {
        $this->inOrder($this->getLeft($node), $callback);
        $callback($node);
        $this->inOrder($this->getRight($node), $callback);
    }

    /**
     * Get nodes in vertical order.
     *
     * @param Node $node Tree node
     * @param int $horizontalDistance Horizontal distance
     * @param Node[] &$order Ordered nodes by horizontal distance
     *
     * @since  1.0.0
     */
    private function getVerticalOrder(Node $node, int $horizontalDistance = 0, array &$order) 
    {
        if (!isset($order[$horizontalDistance])) {
            $order[$horizontalDistance] = [];
        }

        $order[$horizontalDistance][] = $node;
        $left = $this->getLeft($node);
        $right = $this->getRight($node);

        if (isset($left)) {
            $this->getVerticalOrder($left, $horizontalDistance - 1, $order);
        }

        if (isset($right)) {
            $this->getVerticalOrder($right, $horizontalDistance + 1, $order);
        }
    }

    /**
     * Perform action on tree in vertical-order.
     *
     * @param Node $node Tree node
     * @param \Closure $callback Task to perform on node
     *
     * @since  1.0.0
     */
    public function verticalOrder(Node $node, \Closure $callback)
    {
        $order = [];
        $this->getVerticalOrder($node, 0, $order);

        foreach ($order as $level) {
            foreach ($level as $node) {
                $callback($node);
            }
        }
    }

    /**
     * Check if tree is symmetric.
     *
     * @param Node $node1 Tree node1
     * @param Node $node2 Tree node2 (optional, can be different tree)
     *
     * @return bool True if tree is symmetric, false if tree is not symmetric
     *
     * @since  1.0.0
     */
    public function isSymmetric(Node $node1 = null, Node $node2 = null) : bool 
    {
        if (!isset($node1) && !isset($node2)) {
            return true;
        }

        $left1 = $this->getLeft($node1);
        $right1 = $this->getRight($node1);

        $left2 = isset($node2) ? $this->getLeft($node1) : $this->getLeft($node2);
        $right2 = isset($node2) ? $this->getRight($node1) : $this->getRight($node2);

        // todo: compare values? true symmetry requires the values to be the same
        if (isset($node1, $node2)) {
            return $this->isSymmetric($left1, $right2) && $this->isSymmetric($right1, $left2);
        }

        return false;
    }
}