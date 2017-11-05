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

namespace phpOMS\Utils\Encoding\Huffman;

/**
 * Gray encoding class
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class Huffman
{
    /**
     * Huffman dictionary.
     *
     * @var Dictionary
     * @since 1.0.0
     */
    private $dictionary = null;

    /**
     * Remove dictionary
     *
     * @since  1.0.0
     */
    public function removeDictionary() /* : void */
    {
        $this->dictionary = null;
    }

    /**
     * Get dictionary
     *
     * @return Dictionary
     *
     * @since  1.0.0
     */
    public function getDictionary() /* : ?Dictionary */
    {
        return $this->dictionary;
    }

    /**
     * Set dictionary
     *
     * @param Dictionary $dictionary Huffman dictionary
     *
     * @since  1.0.0
     */
    public function setDictionary(Dictionary $dictionary) /* : void */
    {
        $this->dictionary = $dictionary;
    }

    /**
     * Encode.
     *
     * @param string $source Source to encode
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function encode(string $source) : string
    {
        if (empty($source)) {
            return '';
        }

        if (!isset($this->dictionary)) {
            $this->dictionary = new Dictionary($source);
        }

        $binary = '';
        for ($i = 0; isset($source[$i]); ++$i) {
            $binary .= $this->dictionary->get($source[$i]);
        }

        $splittedBinaryString = str_split('1' . $binary . '1', 8);
        $binary               = '';

        foreach ($splittedBinaryString as $i => $c) {
            while (strlen($c) < 8) {
                $c .= '0';
            }

            $binary .= chr(bindec($c));
        }

        return $binary;
    }

    /**
     * Decode.
     *
     * @param string $raw Raw to decode
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function decode(string $raw) : string
    {
        if (empty($raw)) {
            return '';
        }

        $binary    = '';
        $rawLenght = strlen($raw);
        $source    = '';

        for ($i = 0; $i < $rawLenght; ++$i) {
            $decbin = decbin(ord($raw[$i]));

            while (strlen($decbin) < 8) {
                $decbin = '0' . $decbin;
            }

            if ($i === 0) {
                $decbin = substr($decbin, strpos($decbin, '1') + 1);
            }

            if ($i + 1 === $rawLenght) {
                $decbin = substr($decbin, 0, strrpos($decbin, '1'));
            }

            $binary .= $decbin;

            while (($entry = $this->dictionary->getEntry($binary)) !== null) {
                $source .= $entry;
            }
        }

        return $source;
    }
}