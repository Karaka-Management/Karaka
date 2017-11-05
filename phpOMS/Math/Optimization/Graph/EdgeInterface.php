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
interface EdgeInterface
{
    /**
     * Get edge id.
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getId();

    /**
     * Get edge weight.
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getWeight();

    /**
     * Set weight.
     *
     * @param mixed $weight Weight of edge
     *
     * @since  1.0.0
     */
    public function setWeight($weight);

    /**
     * Get vertices.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getVertices() : array;

    /**
     * Set vertices.
     *
     * @param VerticeInterface $a Vertice a
     * @param VerticeInterface $b Vertice b
     *
     * @since  1.0.0
     */
    public function setVertices(VerticeInterface $a, VerticeInterface $b);
}