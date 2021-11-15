<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
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

    public const LOGIN_FORGOTTEN_COUNT = '1000000010';

    public const LOGIN_FORGOTTEN_DATE = '1000000011';

    public const LOGIN_FORGOTTEN_TOKEN = '1000000012';

    public const LOGGING_STATUS = '1000000006';

    public const LOGGING_PATH = '1000000007';

    public const DEFAULT_ORGANIZATION = '1000000009';

    public const LOGIN_STATUS = '1000000013';

    public const DEFAULT_LOCALIZATION = '1000000014';

    public const MAIL_SERVER_ADDR = '1000000015';

    public const MAIL_SERVER_TYPE = '1000000016';

    public const MAIL_SERVER_USER = '1000000017';

    public const MAIL_SERVER_PASS = '1000000018';

    public const MAIL_SERVER_CERT = '1000000019';

    public const MAIL_SERVER_KEY = '1000000020';

    public const MAIL_SERVER_KEYPASS = '1000000021';

    public const MAIL_SERVER_TLS = '1000000022';
}
