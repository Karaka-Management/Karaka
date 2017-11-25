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
namespace Modules\Accounting\Models;

/**
 * Invoice posting simple class.
 *
 * @category   Module
 * @package    Accounting
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class InvoicePostingSimple extends PostingAbstract
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

}
