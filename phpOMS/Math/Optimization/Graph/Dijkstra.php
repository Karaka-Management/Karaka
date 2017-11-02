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
 namespace phpOMS\Math\Optimization\Graph;

class Dijkstra
{
    public static function dijkstra(Graph $graph, $source, $target)
    {
        $vertices   = [];
        $neighbours = [];
        $graphArray = $graph->getEdges();

        foreach ($graphArray as $edge) {
            array_push($vertices, $edge[0], $edge[1]);
            $neighbours[$edge[0]][] = ["end" => $edge[1], "cost" => $edge[2]];
            $neighbours[$edge[1]][] = ["end" => $edge[0], "cost" => $edge[2]];
        }

        $vertices = array_unique($vertices);

        $dist     = [];
        $previous = [];
        foreach ($vertices as $vertex) {
            $dist[$vertex]     = INF;
            $previous[$vertex] = null;
        }

        $dist[$source] = 0;
        $Q             = $vertices;

        while (count($Q) > 0) {

            // TODO - Find faster way to get minimum
            $min = INF;

            foreach ($Q as $vertex) {
                if ($dist[$vertex] < $min) {
                    $min = $dist[$vertex];
                    $u   = $vertex;
                }
            }

            $Q = array_diff($Q, [$u]);

            if ($dist[$u] == INF || $u == $target) {
                break;
            }

            if (isset($neighbours[$u])) {
                foreach ($neighbours[$u] as $arr) {
                    $alt = $dist[$u] + $arr["cost"];

                    if ($alt < $dist[$arr["end"]]) {
                        $dist[$arr["end"]]     = $alt;
                        $previous[$arr["end"]] = $u;
                    }
                }
            }
        }

        $path = [];
        $u    = $target;

        while (isset($previous[$u])) {
            array_unshift($path, $u);
            $u = $previous[$u];
        }

        array_unshift($path, $u);

        return $path;
    }
}