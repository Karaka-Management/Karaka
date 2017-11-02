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

namespace phpOMS\Pattern;


/**
 * Observer.
 *
 * @category   Pattern
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface Observer
{

    /**
     * Subject updated.
     *
     * @param Subject $subject Subject
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function update(Subject $subject);
}
