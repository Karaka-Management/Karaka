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

namespace phpOMS\Message\Http;

/**
 * Rest request class.
 *
 * @category   Framework
 * @package    phpOMS\Request
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Rest
{

    /**
     * Make request.
     *
     * @param Request $request Request
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function request(Request $request) : string
    {
        $curl = curl_init();

        switch ($request->getMethod()) {
            case RequestMethod::POST:
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($request->getData() !== null) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $request->getData());
                }
                break;
            case RequestMethod::PUT:
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
        }

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $request->getUri()->__toString());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
