<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Module;

use phpOMS\System\File\PathException;
use phpOMS\System\File\Local\File;
use phpOMS\System\File\Local\Directory;
use phpOMS\System\File\Local\LocalStorage;
use phpOMS\Utils\IO\Zip\Zip;
use phpOMS\Utils\StringUtils;

/**
 * Package Manager model.
 * 
 * The package manager is responsible for handling installation and update packages for modules, frameworks and resources.
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class PackageManager
{
    /**
     * File path.
     *
     * @var string
     * @since 1.0.0
     */
    private $path = '';

    /**
     * Base path.
     *
     * @var string
     * @since 1.0.0
     */
    private $basePath = '';

    /**
     * Extract path.
     *
     * @var string
     * @since 1.0.0
     */
    private $extractPath = '';

    /**
     * Info data.
     *
     * @var array
     * @since 1.0.0
     */
    private $info = [];

    /**
     * Constructor.
     * 
     * @param string $path Package source path e.g. path after download.
     * @param string $basePath Path of the application
     *
     * @since  1.0.0
     */
    public function __construct(string $path, string $basePath) 
    {
        $this->path = $path;
        $this->basePath = $basePath;
    }

    /**
     * Extract package to temporary destination
     * 
     * @param string $path Temporary extract path
     * 
     * @return void
     * 
     * @since  1.0.0
     */
    public function extract(string $path) /* : void */
    {
        $this->extractPath = $path;
        Zip::unpack($this->path, $this->extractPath);
    }

    /**
     * Load info data from path.
     *
     * @return void
     *
     * @throws PathException This exception is thrown in case the info file path doesn't exist.
     *
     * @since  1.0.0
     */
    public function load() /* : void */
    {
        if (!file_exists($this->extractPath)) {
            throw new PathException($this->extractPath);
        }

        $this->info = json_decode(file_get_contents($this->extractPath . '/info.json'), true);
    }

    /**
     * Validate package integrity
     * 
     * @return bool Returns true if the package is authentic, false otherwise
     *
     * @since  1.0.0
     */
    public function isValid() : bool
    {
        return $this->authenticate(file_get_contents($this->extractPath . '/package.cert'), $this->hashFiles());
    }

    /**
     * Hash array of files
     * 
     * @return string Hash value of files
     *
     * @since  1.0.0
     */
    private function hashFiles() : string
    {
        $files = Directory::list($this->extractPath . '/package');
        $state = \sodium_crypto_generichash_init();

        foreach ($files as $file) {
            if ($file === 'package.cert') {
                continue; 
            }

            \sodium_crypto_generichash_update($state, file_get_contents($this->extractPath . '/package/' . $file));
        }

        return \sodium_crypto_generichash_final();
    }

    /**
     * Install package
     * 
     * @return void
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function install() /* : void */
    {
        if (!$this->isValid()) {
            throw new \Exception();
        }

        foreach ($this->info as $key => $components) {
            if (function_exists($this->{$key})) {
                $this->{$key}($components);
            }
        }
    }

    /**
     * Move files
     *
     * @param mixed $components Component data
     * 
     * @return void
     *
     * @since  1.0.0
     */
    private function move($components)
    {
        foreach ($components as $component) {
            LocalStorage::move($this->basePath . '/' . $component['from'], $this->basePath . '/' . $component['to'], true);
        }
    }

    /**
     * Copy files
     *
     * @param mixed $components Component data
     * 
     * @return void
     *
     * @since  1.0.0
     */
    private function copy($components)
    {
        foreach ($components as $component) {
            if (StringUtils::startsWith($component['from'], 'Package/')) {
                LocalStorage::copy($this->path . '/' . $component['from'], $this->basePath . '/' . $component['to'], true);
            } else {
                LocalStorage::copy($this->basePath . '/' . $component['from'], $this->basePath . '/' . $component['to'], true);
            }
        }
    }

    /**
     * Delete files
     *
     * @param mixed $components Component data
     * 
     * @return void
     *
     * @since  1.0.0
     */
    private function delete($components)
    {
        foreach ($components as $component) {
            LocalStorage::delete($this->basePath . '/' . $component);
        }
    }

    /**
     * Execute commands
     *
     * @param mixed $components Component data
     * 
     * @return void
     *
     * @since  1.0.0
     */
    private function execute($components) 
    {
        foreach ($components as $component) {
            include $this->basePath . '/' . $component;
        }
    }

    /**
     * Cleanup after installation
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function cleanup() 
    {
        File::delete($this->path);
        Directory::delete($this->extractPath);
    }

    /**
     * Authenticate package
     *
     * @param string $signedHash Hash to authenticate
     * @param string $rawHash Hash to compare against
     * 
     * @return bool
     *
     * @since  1.0.0
     */
    private function authenticate(string $signedHash, string $rawHash) : bool
    {
        // https://3v4l.org/PN9Xl
        $publicKey = 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAjr73rerPRq3ZwWmrUKsN
        Bjg8Wy5lnyWu9HCRQz0fix6grz+NOOsr4m/jazB2knfdtn7fi5XifbIbmrNJY8e6
        musCJ0FTgJPVBqVk7XAFVSRe2gUaCPZrTPtfZ00C3cynjwTlxSdjNtU9N0ZAo17s
        VWghH8ki4T2d5Mg1erGOtMJzp5yw47UHUa+KbxUmUV25WMcRYyi7+itD2xANF2AE
        +PQZT1dSEU8++NI+zT6tXD/Orv5ikk0whoVqvo6duWejx5n5cpJB4EiMo4Q7epbw
        9uMo9uIKqgQ9y3KdT36GBQkBErFf1dhf8KYJBGYMhO1UJE11dY3XrA7Ij1+zK+ai
        duQHOc5EMClUGZQzCJAIU5lj4WEHQ4Lo0gop+fx9hzuBTDxdyOjWSJzkqyuWMkq3
        zEpRBay785iaglaue9XDLee58wY+toiGLBfXe73gsbDqDSOll+cQYNjrronVN7sU
        Dc2WyTIVW1Z8KFwK10D3SW0oEylCaGLtClyyihuW7JPu/8Or1Zjf87W82XTm31Fp
        YkRgoEMDtVHZq0N2eHpLz1L8zKyT0ogZYN5eH5VlGrPcpwbAludNKlgAJ0hrgED1
        9YsCBLwJQpFa4VZP7A5a/Qcw8EFAvNkgaPpBbAAtWoDbyOQsez6Jsdan/enfZ18+
        LL7qOB5oFFM/pKlTIeVS+UsCAwEAAQ==';
        $unsignedHash = \sodium_crypto_sign_open($signedHash, $publicKey);

        return $unsignedHash === $rawHash;
    }
}