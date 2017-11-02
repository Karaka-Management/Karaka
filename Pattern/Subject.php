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
 * Subject.
 *
 * @category   Pattern
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface Subject
{

    /**
     * Attach observer to subject.
     *
     * @param Observer $observer Observer
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function attach(Observer $observer);

    /**
     * Detach observer.
     *
     * @param Observer $observer Observer
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function detach(Observer $observer);

    /**
     * Notify observer of change.
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function notify();
}
