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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Stdlib\Graph;

/**
 * Tree class.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Tree extends Graph
{
    /**
     * Root node.
     *
     * @var Node
     * @since 1.0.0
     */
    private $root = null;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $root = new Node();
        parent::addNode($root);
    }

    /**
     * Add a note relative to a node.
     *
     * @param Node $base Base node
     * @param Node $node Node to add
     *
     * @return Tree
     *
     * @since  1.0.0
     */
    public function addRelativeNode(Node $base, Node $node) : Tree
    {
        parent::addNode($node);
        parent::addEdge(new Edge($base, $node));

        return $this;
    }

    /**
     * Get maximum tree depth.
     *
     * @param Node $node Tree node
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getMaxDepth(Node $node = null) : int 
    {
        $currentNode = $node ?? $this->root;

        if (!isset($currentNode)) {
            return 0;
        }

        $depth = 1;
        $neighbors = $this->getNeighbors($currentNode);

        foreach ($neighbors as $neighbor) {
            $depth = max($depth, $depth + $this->getMaxDepth($neighbor));
        }

        return $depth;
    }

    /**
     * Get minimum tree path.
     *
     * @param Node $node Tree node
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getMinDepth(Node $node = null) : int
    {
        $currentNode = $node ?? $this->root;

        if (!isset($currentNode)) {
            return 0;
        }

        $depth = [];
        $neighbors = $this->getNeighbors($currentNode);

        foreach ($neighbors as $neighbor) {
            $depth[] = $this->getMaxDepth($neighbor);
        }

        $depth = empty($depth) ? 0 : $depth;

        return min($depth) + 1;
    }

    /**
     * Perform task on tree nodes in level order.
     *
     * @param Node $node Tree node
     * @param \Closure $callback Task to perform
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function levelOrder(Node $node, \Closure $callback)
    {
        $depth = $this->getMaxDepth();

        for ($i = 1; $i < $depth; $i++) {
            $nodes = $this->getLevel($i);
            callback($nodes);
        }
    }

    /**
     * Check if node is leaf.
     *
     * @param Node $node Tree node
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function isLeaf(Node $node) : bool 
    {
        return count($this->getEdgesOfNode($node)) === 1;
    }

    /**
     * Get all nodes of a specific level.
     *
     * @param int $level Level to retrieve
     * @param Node $node Tree node
     *
     * @return Node[]
     *
     * @since  1.0.0
     */
    public function getLevelNodes(int $level, Node $node) : array
    {
        --$level;
        $neighbors = $this->getNeighbors($node);
        $nodes = [];

        if ($level === 1) {
            return $neighbors;
        }

        foreach ($neighbors as $neighbor) {
            array_merge($nodes, $this->getLevelNodes($level, $neighbor));
        }

        return $nodes;
    }

    /**
     * Check if the tree is full.
     *
     * @param int $type Child nodes per non-leaf node
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function isFull(int $type) : bool 
    {
        if (count($this->edges) % $type !== 0) {
            return false;
        }

        foreach ($this->nodes as $node) {
            $neighbors = count($this->getNeighbors($node));

            if ($neighbors !== $type && $neighbors !== 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Perform action on tree in pre-order.
     *
     * @param Node $node Tree node
     * @param \Closure $callback Task to perform on node
     *
     * @since  1.0.0
     */
    public function preOrder(Node $node, \Closure $callback) {
        if (count($this->nodes) === 0) {
            return;
        }

        $callback($node);
        $neighbors = $this->getNeighbors($node);

        foreach ($neighbors as $neighbor) {
            // todo: get neighbors needs to return in ordered way
            $this->preOrder($neighbor, $callback);
        }
    }
    
    /**
     * Perform action on tree in post-order.
     *
     * @param Node $node Tree node
     * @param \Closure $callback Task to perform on node
     *
     * @since  1.0.0
     */
    public function postOrder(Node $node, \Closure $callback) {
        if (count($this->nodes) === 0) {
            return;
        }
        
        $neighbors = $this->getNeighbors($node);

        foreach ($neighbors as $neighbor) {
            // todo: get neighbors needs to return in ordered way
            $this->postOrder($neighbor, $callback);
        }

        $callback($node);
    }
}