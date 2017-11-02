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

namespace phpOMS\Utils\RnG;

/**
 * Text generator.
 *
 * @category   Framework
 * @package    RnG
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Text
{

    /**
     * Vocabulary.
     *
     * @var string[]
     * @since 1.0.0
     */
    private static $words_west = [
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 'curabitur', 'vel', 'hendrerit', 'libero', 
        'eleifend', 'blandit', 'nunc', 'ornare', 'odio', 'ut', 'orci', 'gravida', 'imperdiet', 'nullam', 'purus', 'lacinia', 'a', 
        'pretium', 'quis', 'congue', 'praesent', 'sagittis', 'laoreet', 'auctor', 'mauris', 'non', 'velit', 'eros', 'dictum', 
        'proin', 'accumsan', 'sapien', 'nec', 'massa', 'volutpat', 'venenatis', 'sed', 'eu', 'molestie', 'lacus', 'quisque', 
        'porttitor', 'ligula', 'dui', 'mollis', 'tempus', 'at', 'magna', 'vestibulum', 'turpis', 'ac', 'diam', 'tincidunt', 'id', 
        'condimentum', 'enim', 'sodales', 'in', 'hac', 'habitasse', 'platea', 'dictumst', 'aenean', 'neque', 'fusce', 'augue', 
        'leo', 'eget', 'semper', 'mattis', 'tortor', 'scelerisque', 'nulla', 'interdum', 'tellus', 'malesuada', 'rhoncus', 'porta', 
        'sem', 'aliquet', 'et', 'nam', 'suspendisse', 'potenti', 'vivamus', 'luctus', 'fringilla', 'erat', 'donec', 'justo', 
        'vehicula', 'ultricies', 'varius', 'ante', 'primis', 'faucibus', 'ultrices', 'posuere', 'cubilia', 'curae', 'etiam', 
        'cursus', 'aliquam', 'quam', 'dapibus', 'nisl', 'feugiat', 'egestas', 'class', 'aptent', 'taciti', 'sociosqu', 'ad', 
        'litora', 'torquent', 'per', 'conubia', 'nostra', 'inceptos', 'himenaeos', 'phasellus', 'nibh', 'pulvinar', 'vitae', 
        'urna', 'iaculis', 'lobortis', 'nisi', 'viverra', 'arcu', 'morbi', 'pellentesque', 'metus', 'commodo', 'ut', 'facilisis', 
        'felis', 'tristique', 'ullamcorper', 'placerat', 'aenean', 'convallis', 'sollicitudin', 'integer', 'rutrum', 'duis', 'est', 
        'etiam', 'bibendum', 'donec', 'pharetra', 'vulputate', 'maecenas', 'mi', 'fermentum', 'consequat', 'suscipit', 'aliquam', 
        'habitant', 'senectus', 'netus', 'fames', 'quisque', 'euismod', 'curabitur', 'lectus', 'elementum', 'tempor', 'risus', 
        'cras',
    ];

    /**
     * Text has random formatting.
     *
     * @var bool
     * @since 1.0.0
     */
    private $hasFormatting = false;

    /**
     * Text has paragraphs.
     *
     * @var bool
     * @since 1.0.0
     */
    private $hasParagraphs = false;

    /**
     * Amount of sentences of the last generated text.
     *
     * @var int
     * @since 1.0.0
     */
    private $sentences = 0;

    /**
     * Set if the text should have formatting.
     *
     * @param bool $hasFormatting
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setFormatting($hasFormatting) /* : void */
    {
        $this->hasFormatting = $hasFormatting;
    }

    /**
     * Set if the text should have paragraphs.
     *
     * @param bool $hasParagraphs
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setParagraphs($hasParagraphs) /* : void */
    {
        $this->hasParagraphs = $hasParagraphs;
    }

    /**
     * Amount of sentences of the last generated text.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getSentences() : int
    {
        return $this->sentences;
    }

    /**
     * Get a random string.
     *
     * @param int $length Text length
     * @param int $words  Vocabulary
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function generateText(int $length, $words = null) : string
    {
        if ($length === 0) {
            return '';
        }

        if ($words === null) {
            $words = self::$words_west;
        }

        $punctuation       = $this->generatePunctuation($length);
        $punctuation_count = array_count_values(
                array_map(
                    function ($item) {
                        return $item[1];
                    },
                    $punctuation
                )
            ) + ['.' => 0, '!' => 0, '?' => '?'];

        $this->sentences = $punctuation_count['.'] + $punctuation_count['!'] + $punctuation_count['?'];

        if ($this->hasParagraphs) {
            $paragraph = $this->generateParagraph($this->sentences);
        }

        if ($this->hasFormatting) {
            $formatting = $this->generateFormatting($length);
        }

        $sentenceCount = 0;
        $text          = '';
        $puid          = 0;
        $paid          = 0;
        $wordCount     = count($words);

        for ($i = 0; $i < $length + 1; $i++) {
            $newSentence = false;

            $lastChar = substr($text, -1);

            if ($lastChar === '.' || $lastChar === '!' || $lastChar === '?' || !$lastChar) {
                $newSentence = true;
            }

            $word = $words[rand(0, $wordCount - 1)];

            if ($newSentence) {
                $word = ucfirst($word);
                $sentenceCount++;

                /** @noinspection PhpUndefinedVariableInspection */
                if ($this->hasParagraphs && $sentenceCount === $paragraph[$paid]) {
                    $paid++;

                    $text .= '</p><p>';
                }
            }

            /** @noinspection PhpUndefinedVariableInspection */
            if ($this->hasFormatting && array_key_exists($i, $formatting)) {
                $word = '<' . $formatting[$i] . '>' . $word . '</' . $formatting[$i] . '>';
            }

            $text .= ' ' . $word;

            if ($punctuation[$puid][0] === $i) {
                $text .= $punctuation[$puid][1];
                $puid++;
            }
        }

        $text = ltrim($text);

        if ($this->hasParagraphs) {
            $text = '<p>' . $text . '</p>';
        }

        return $text;
    }

    /**
     * Generate punctuation.
     *
     * @param int $length Text length
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function generatePunctuation(int $length) : array
    {
        $minSentences    = 4;
        $maxSentences    = 20;
        $minCommaSpacing = 3;
        $probComma       = 0.2;
        $probDot         = 0.8;
        $probExc         = 0.4;

        $punctuation = [];

        for ($i = 0; $i < $length;) {
            $sentenceLength = rand($minSentences, $maxSentences);

            if ($i + $sentenceLength > $length || $length - ($i + $sentenceLength) < $minSentences) {
                $sentenceLength = $length - $i;
            }

            /* Handle comma */
            $comma_here = (rand(0, 100) <= $probComma * 100 && $sentenceLength >= 2 * $minCommaSpacing ? true : false);
            $posComma   = [];

            if ($comma_here) {
                $posComma[]    = rand($minCommaSpacing, $sentenceLength - $minCommaSpacing);
                $punctuation[] = [$i + $posComma[0], ','];

                $comma_here = (rand(0, 100) <= $probComma * 100 && $posComma[0] + $minCommaSpacing * 2 < $sentenceLength ? true : false);

                if ($comma_here) {
                    $posComma[]    = rand($posComma[0] + $minCommaSpacing, $sentenceLength - $minCommaSpacing);
                    $punctuation[] = [$i + $posComma[1], ','];
                }
            }

            $i += $sentenceLength;

            /* Handle sentence ending */
            $is_dot = (rand(0, 100) <= $probDot * 100 ? true : false);

            if ($is_dot) {
                $punctuation[] = [$i, '.'];
                continue;
            }

            $is_ex = (rand(0, 100) <= $probExc * 100 ? true : false);

            if ($is_ex) {
                $punctuation[] = [$i, '!'];
                continue;
            }

            $punctuation[] = [$i, '?'];
        }

        return $punctuation;
    }

    /**
     * Generate paragraphs.
     *
     * @param int $length Amount of sentences
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function generateParagraph(int $length) /* : void */
    {
        $minSentence = 3;
        $maxSentence = 10;

        $paragraph = [];

        for ($i = 0; $i < $length;) {
            $paragraphLength = rand($minSentence, $maxSentence);

            if ($i + $paragraphLength > $length || $length - ($i + $paragraphLength) < $minSentence) {
                $paragraphLength = $length - $i;
            }

            $i += $paragraphLength;
            $paragraph[] = $i;
        }

        return $paragraph;
    }

    /**
     * Generate random formatting.
     *
     * @param int $length Amount of words
     *
     * @return string[]
     *
     * @since  1.0.0
     */
    private function generateFormatting(int $length) : array
    {
        $probCursive = 0.005;
        $probBold    = 0.005;
        $probUline   = 0.005;

        $formatting = [];

        for ($i = 0; $i < $length; $i++) {
            $isCursive = (rand(0, 1000) <= 1000 * $probCursive ? true : false);
            $isBold    = (rand(0, 1000) <= 1000 * $probBold ? true : false);
            $isUline   = (rand(0, 1000) <= 1000 * $probUline ? true : false);

            if ($isUline) {
                $formatting[$i] = 'u';
            }

            if ($isBold) {
                $formatting[$i] = 'b';
            }

            if ($isCursive) {
                $formatting[$i] = 'i';
            }
        }

        return $formatting;
    }
}
