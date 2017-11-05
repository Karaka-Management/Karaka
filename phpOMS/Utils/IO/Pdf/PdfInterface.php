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

namespace phpOMS\Utils\IO\Pdf;

/**
 * Pdf interface.
 *
 * @category   Framework
 * @package    Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface PdfInterface
{

    /**
     * Export Pdf.
     *
     * @param string $path Path to export
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function exportPdf($path);
}
