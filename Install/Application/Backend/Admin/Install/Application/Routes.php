<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
	'^/legal/privacy(\?.*$|$)' => [
        [
            'dest'       => '\Web\Backend\Controller\PageController:viewLegalDocuments',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => null,
                'type'   => PermissionType::READ,
                'state'  => null,
            ],
        ],
    ],

    '^/legal/terms(\?.*$|$)' => [
        [
            'dest'       => '\Web\Backend\Controller\PageController:viewLegalDocuments',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => null,
                'type'   => PermissionType::READ,
                'state'  => null,
            ],
        ],
    ],

    '^/legal/imprint(\?.*$|$)' => [
        [
            'dest'       => '\Web\Backend\Controller\PageController:viewLegalDocuments',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => null,
                'type'   => PermissionType::READ,
                'state'  => null,
            ],
        ],
    ],
];
