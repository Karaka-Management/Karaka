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

namespace phpOMS\Utils\Parser\Markdown;

/**
 * Array utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Markdown
{
    private static $blockTypes = [
        '#' => ['Header'],
        '*' => ['Rule', 'List'],
        '+' => ['List'],
        '-' => ['SetextHeader', 'Table', 'Rule', 'List'],
        '0' => ['List'],
        '1' => ['List'],
        '2' => ['List'],
        '3' => ['List'],
        '4' => ['List'],
        '5' => ['List'],
        '6' => ['List'],
        '7' => ['List'],
        '8' => ['List'],
        '9' => ['List'],
        ':' => ['Table'],
        '<' => ['Comment', 'Markup'],
        '=' => ['SetextHeader'],
        '>' => ['Quote'],
        '[' => ['Reference'],
        '_' => ['Rule'],
        '`' => ['FencedCode'],
        '|' => ['Table'],
        '~' => ['FencedCode'],
    ];

    private static $inlineTypes = [
        '"'  => ['SpecialCharacter'],
        '!'  => ['Image'],
        '&'  => ['SpecialCharacter'],
        '*'  => ['Emphasis'],
        ':'  => ['Url'],
        '<'  => ['UrlTag', 'EmailTag', 'Markup', 'SpecialCharacter'],
        '>'  => ['SpecialCharacter'],
        '['  => ['Link'],
        '_'  => ['Emphasis'],
        '`'  => ['Code'],
        '~'  => ['Strikethrough'],
        '\\' => ['EscapeSequence'],
    ];

    private static $tags = [
        'calendar' => [
            'match'  => 'regex here',
            'parsed' => 'output here',
        ],
    ];

    public function __construct()
    {
    }

    public function parse(string $raw) : string
    {
        /*$raw   = $this->cleanup($raw);
        $lines = explode("\n", $raw);

        return trim($this->parseLines($lines), " \n");*/

        return $raw;
    }

    private function cleanup(string $raw) : string
    {
        $raw = str_replace(["\r\n", "\r", "\t"], ["\n", "\n", '    '], $raw);
        $raw = trim($raw);
        $raw = trim($raw, "\n");

        return $raw;
    }

    private function parseLines(array $lines) : string
    {
        $block = array_keys(self::$blockTypes);
        $inline = array_keys(self::$inlineTypes);

        foreach ($lines as $line) {
            foreach ($line as $character) {
                
            }
        }

        return '';
    }

    private function countIndention(string $line) : int
    {
        $indent = 0;
        while (isset($line[$indent]) && $line[$indent] === ' ') {
            $indent++;
        }

        return $indent;
    }
}