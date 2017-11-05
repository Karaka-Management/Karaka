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

namespace phpOMS\Uri;

/**
 * UriFactory class.
 *
 * Used in order to create a uri
 *
 * @category   Framework
 * @package    phpOMS/Uri
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class UriFactory
{

    /**
     * Dynamic query elements.
     *
     * @var string[]
     * @since 1.0.0
     */
    private static $uri = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Set global query replacements.
     *
     * @param string $key Replacement key
     *
     * @return null|string
     *
     * @since  1.0.0
     */
    public static function getQuery(string $key) /* : ?string */
    {
        return self::$uri[$key] ?? null;
    }

    /**
     * Set global query replacements.
     *
     * @param string $key       Replacement key
     * @param string $value     Replacement value
     * @param bool   $overwrite Overwrite if already exists
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function setQuery(string $key, string $value, bool $overwrite = true) : bool
    {
        if ($overwrite || !isset(self::$uri[$key])) {
            self::$uri[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Clear all uri components
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function clearAll() : bool 
    {
        self::$uri = [];

        return true;
    }

    /**
     * Setup uri builder based on current request
     *
     * @param UriInterface $uri Uri
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function setupUriBuilder(UriInterface $uri) /* : void */
    {
        self::setQuery('/scheme', $uri->getScheme());
        self::setQuery('/host', $uri->getHost());
        self::setQuery('/base', rtrim($uri->getBase(), '/'));
        self::setQuery('/rootPath', $uri->getRootPath());
        self::setQuery('?', $uri->getQuery());
        self::setQuery('%', $uri->__toString());
        self::setQuery('#', $uri->getFragment());
        self::setQuery('/', $uri->getPath());
        self::setQuery(':user', $uri->getUser());
        self::setQuery(':pass', $uri->getPass());

        $data = $uri->getQueryArray();
        foreach ($data as $key => $value) {
            self::setQuery('?' . $key, $value);
        }
    }

    /**
     * Clear uri component
     *
     * @param string $key Uri component key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function clear(string $key) : bool 
    {
        if (isset(self::$uri[$key])) {
            unset(self::$uri[$key]);

            return true;
        }

        return false;
    }

    /**
     * Clear uri components that follow a certain pattern
     *
     * @param string $pattern Uri key pattern to remove
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function clearLike(string $pattern) : bool 
    {
        $success = false;

        foreach (self::$uri as $key => $value) {
            if (((bool) preg_match('~^' . $pattern . '$~', $key))) {
                unset(self::$uri[$key]);
                $success = true;
            }
        }

        return $success;
    }

    /**
     * Simplify url
     *
     * While adding, and removing elements to a uri it can have multiple parameters or empty parameters which need to be cleaned up
     *
     * @param string $url Url to simplify
     *
     * @return string
     *
     * @since  1.0.0
     */
    private static function unique(string $url) : string
    {
        $parts = explode('?', $url);

        if (count($parts) >= 2) {
            $full   = $parts[1];
            $pars   = explode('&', $full);
            $comps  = [];
            $length = count($pars);

            for ($i = 0; $i < $length; $i++) {
                $spl = explode('=', $pars[$i]);

                if (isset($spl[1])) {
                    $comps[$spl[0]] = $spl[1];
                }
            }

            $pars = [];
            foreach ($comps as $key => $value) {
                $pars[] = $key . '=' . $value;
            }

            $url = $parts[0] . (empty($pars) ? '' : '?' . implode('&', $pars));
        }

        return $url;
    }

    /**
     * Build uri.
     *
     * # = DOM id
     * . = DOM class
     * / = Current path
     * ? = Current query
     * @ =
     * $ = Other data
     *
     * @param string $uri     Path data
     * @param array  $toMatch Optional special replacements
     *
     * @return null|string
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function build(string $uri, array $toMatch = []) /* : ?string */
    {
        $parsed = preg_replace_callback('(\{[\/#\?%@\.\$][a-zA-Z0-9\-]*\})', function ($match) use ($toMatch) {
            $match = substr($match[0], 1, strlen($match[0]) - 2);

            return $toMatch[$match] ?? self::$uri[$match] ?? $match;
        }, $uri);

        // todo: maybe don't do this and adjust unique?!
        if (strpos($parsed, '?')) {
            str_replace('&', '?', $parsed);
        }

        return self::unique($parsed);
    }
}
