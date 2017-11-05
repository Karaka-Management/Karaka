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

namespace phpOMS\Math\Optimization\Graph;

/**
 * Graph class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface VerticeInterface
{
    /**
     * Get vertice id.
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getId();

    /**
     * Get edges.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getEdges() : array;

    /**
     * Add edge.
     *
     * @param EdgeInterface $edge Edge to add to vertice
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function addEdge(EdgeInterface $edge) : bool;
}
