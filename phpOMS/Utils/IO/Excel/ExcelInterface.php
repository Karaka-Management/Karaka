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

namespace phpOMS\Utils\IO\Excel;

/**
 * Excel interface.
 *
 * @category   Framework
 * @package    Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface ExcelInterface
{

    /**
     * Export Excel.
     *
     * @param string $path Path to export
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function exportExcel($path);

    /**
     * Import Excel.
     *
     * @param string $path Path to import
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function importExcel($path);
}
