<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Stdlib\Base\Enum;

/**
 * Default settings enum.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
abstract class SettingsEnum extends Enum
{
    public const PASSWORD_PATTERN = '1000000001';

    public const LOGIN_TIMEOUT = '1000000002';

    public const PASSWORD_INTERVAL = '1000000003';

    public const PASSWORD_HISTORY = '1000000004';

    public const LOGIN_TRIES = '1000000005';

    public const LOGGING_STATUS = '1000000006';

    public const LOGGING_PATH = '1000000007';

    public const DEFAULT_ORGANIZATION = '1000000009';

    public const LOGIN_STATUS = '1000000013';

    public const DEFAULT_LOCALIZATION = '1000000014';

    public const ADMIN_MAIL = '1000000015';
}
