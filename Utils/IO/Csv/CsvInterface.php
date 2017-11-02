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

namespace phpOMS\Utils\IO\Csv {

    /**
     * Cvs interface.
     *
     * PHP Version 7.1
     *
     * @category   Framework
     * @package    Utils
     * @copyright  Dennis Eichhorn
     * @license    OMS License 1.0
     * @version    1.0.0
     * @link       http://orange-management.com
     * @since      1.0.0
     */
    interface CsvInterface
    {
        /**
         * Export Csv.
         *
         * @param string $path Path to export
         *
         * @since  1.0.0
         * @author Dennis Eichhorn <d.eichhorn@oms.com>
         */
        public function exportCsv($path);

        /**
         * Import Csv.
         *
         * @param string $path Path to import
         *
         * @since  1.0.0
         * @author Dennis Eichhorn <d.eichhorn@oms.com>
         */
        public function importCsv($path);
    }
}
