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
 */
class Graph
{
    /**
     * Nodes.
     *
     * @var array
     * @since 1.0.0
     */
    protected $nodes = [];

    /**
     * Edges.
     *
     * @var array
     * @since 1.0.0
     */
    protected $edges = [];

    /**
     * Add node to graph.
     *
     * @param Node $node Graph node
     *
     * @return Graph
     *
     * @since  1.0.0
     */
    public function addNode(Node $node) : Graph
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * Add node to graph.
     *
     * @param Node $relative Relative graph node
     * @param Node $node     Graph node
     *
     * @return Graph
     *
     * @since  1.0.0
     */
    public function addNodeRelative(Node $relative, Node $node) : Graph
    {
        return $this;
    }

    /**
     * Set node in graph.
     *
     * @param mixed $key  Key of node
     * @param Node  $node Graph node
     *
     * @return Graph
     *
     * @since  1.0.0
     */
    public function setNode($key, Node $node) : Graph
    {
        $this->nodes[$key] = $node;

        return $this;
    }

    /**
     * Add edge to graph.
     *
     * @param Edge $edge Graph edge
     *
     * @return Graph
     *
     * @since  1.0.0
     */
    public function addEdge(Edge $edge) : Graph
    {
        $this->edges[] = $edge;

        return $this;
    }

    /**
     * Set edge in graph.
     *
     * @param mixed $key  Edge key
     * @param Edge  $edge Edge to set
     *
     * @return Graph
     *
     * @since  1.0.0
     */
    public function setEdge($key, Edge $edge)  /* : void */
    {
        $this->edges[$key] = $edge;

        return $this;
    }

    /**
     * Get graph node
     *
     * @param mixed $key Node key
     *
     * @return Node
     *
     * @since  1.0.0
     */
    public function getNode($key) : Node
    {
        return $this->nodes[$key];
    }

    /**
     * Get graph nodes
     *
     * @return Node[]
     *
     * @since  1.0.0
     */
    public function getNodes() : array
    {
        return $this->nodes;
    }

    /**
     * Get graph edge.
     *
     * @param mixed $key Edge key
     *
     * @return Edge
     *
     * @since  1.0.0
     */
    public function getEdge($key) : Edge
    {
        return $this->edges[$key];
    }

    /**
     * Get all edges of a node
     *
     * @param mixed $node Node
     *
     * @return Edge[]
     *
     * @since  1.0.0
     */
    public function getEdgesOfNode($node) : array
    {
        if (!($node instanceof Node)) {
            $node = $this->getNode($node);
        }

        $edges = [];
        foreach ($this->edges as $edge) {
            $nodes = $edge->getNodes();

            if ($nodes[0] === $node || $nodes[1] === $node) {
                $edges[] = $edge;
            }
        }

        return $edges;
    }

    /**
     * Get all node neighbors.
     *
     * @param Node $node Graph node
     *
     * @return Node[]
     *
     * @since  1.0.0
     */
    public function getNeighbors($node) : array
    {
        if (!($node instanceof Node)) {
            $node = $this->getNode($node);
        }

        $edges     = $this->getEdgesOfNode($node);
        $neighbors = [];

        foreach ($edges as $edge) {
            $nodes = $edge->getNodes();

            if ($nodes[0] !== $node && $nodes[0] !== null) {
                $neighbors[] = $nodes[0];
            } elseif ($nodes[1] !== $node && $nodes[0] !== null) {
                $neighbors[] = $nodes[1];
            }
        }

        return $neighbors;
    }

    /**
     * Get graph dimension.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getDimension() : int
    {
        // todo: implement
        return 0;
    }

    /**
     * Get all bridges.
     *
     * @return Edge[]
     *
     * @since  1.0.0
     */
    public function getBridges() : array
    {
        // todo: implement
        return [];
    }

    /**
     * Get minimal spanning tree using Kruskal's algorithm.
     *
     * @return Tree
     *
     * @since  1.0.0
     */
    public function getKruskalMinimalSpanningTree() : Tree
    {
        // todo: implement
        return new Tree();
    }

    /**
     * Get minimal spanning tree using Prim's algorithm
     *
     * @return Tree
     *
     * @since  1.0.0
     */
    public function getPrimMinimalSpanningTree() : Tree
    {
        // todo: implement
        return new Tree();
    }

    /**
     * Get circles in graph.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getCircle() : array
    {
        // todo: implement
    }

    /**
     * Get shortest path using Floyd Warschall algorithm.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getFloydWarshallShortestPath() : array
    {
        // todo: implement
    }

    /**
     * Get shortest path using Dijkstra algorithm.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getDijkstraShortestPath() : array
    {
        // todo: implement
    }

    /**
     * Perform depth first traversal.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function depthFirstTraversal() : array
    {
        // todo: implement
    }

    /**
     * Perform breadth first traversal.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function breadthFirstTraversal() : array
    {
        // todo: implement
    }

    /**
     * Get longest path in graph.
     *
     * @return Node[]
     *
     * @since  1.0.0
     */
    public function longestPath() : array
    {
        // todo: implement
    }

    /**
     * Get longest path between two nodes.
     *
     * @param Node $node1 Graph node
     * @param Node $node2 Graph node
     *
     * @return Node[]
     *
     * @since  1.0.0
     */
    public function longestPathBetweenNodes(Node $node1, Node $node2) : array
    {
        // todo: implement
    }

    /**
     * Get order of the graph.
     *
     * The order of a graph is the amount of nodes it contains.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getOrder() : int
    {
        return count($this->nodes);
    }

    /**
     * Get size of the graph.
     *
     * The size of the graph is the amount of edges it contains.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getSize() : int
    {
        return count($this->edges);
    }

    /**
     * Get diameter of graph.
     *
     * The diameter of a graph is the longest shortest path between two nodes.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getDiameter() : int
    {
        $diameter = 0;

        foreach ($this->nodes as $node1) {
            foreach ($this->nodes as $node2) {
                if ($node1 === $node2) {
                    continue;
                }

                $diameter = max($diameter, $this->getFloydWarshallShortestPath($node1, $node2));
            }
        }

        return $diameter;
    }

    public function getGirth() : int
    {
        // todo: implement
    }

    public function getCircuitRank() : int
    {
        // todo: implement
    }

    public function getNodeConnectivity() : int
    {
        // todo: implement
    }

    public function getEdgeConnectivity() : int
    {
        // todo: implement
    }

    public function isConnected() : bool
    {
        // todo: implement
        return true;
    }

    public function getUnconnected() : array
    {
        // todo: implement
        // get all unconnected sub graphs
    }

    public function isBipartite() : bool
    {
        // todo: implement
        return true;
    }

    public function isTriangleFree() : bool
    {
        // todo: implement
        return true;
    }

    public function isCircleFree() : bool
    {
        // todo: implement
        return true;
    }
}