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
namespace Modules\Accounting\Models;



/**
 * Posting abstract class.
 *
 * @category   Module
 * @package    Accounting
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class PostingAbstract implements PostingInterface
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
