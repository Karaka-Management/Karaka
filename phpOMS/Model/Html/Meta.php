<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS/Model
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Model\Html;

use phpOMS\Contract\RenderableInterface;

/**
 * Meta class.
 *
 * @category   Framework
 * @package    phpOMS/Model
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Meta implements RenderableInterface
{

    /**
     * Keywords.
     *
     * @var string[]
     * @since 1.0.0
     */
    private $keywords = [];

    /**
     * Author.
     *
     * @var string
     * @since 1.0.0
     */
    private $author = null;

    /**
     * Charset.
     *
     * @var string
     * @since 1.0.0
     */
    private $charset = null;

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = null;

    /**
     * Language.
     *
     * @var string
     * @since 1.0.0
     */
    private $language = 'en';

    /**
     * Add keyword.
     *
     * @param string $keyword Keyword
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addKeyword(string $keyword) /* : void */
    {
        if (!in_array($keyword, $this->keywords)) {
            $this->keywords[] = $keyword;
        }
    }

    /**
     * Get keywords.
     *
     * @return string[] Keywords
     *
     * @since  1.0.0
     */
    public function getKeywords() : array
    {
        return $this->keywords;
    }

    /**
     * Get author.
     *
     * @return string Author
     *
     * @since  1.0.0
     */
    public function getAuthor() : string
    {
        return $this->author;
    }

    /**
     * Set author.
     *
     * @param string $author Author
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAuthor(string $author) /* : void */
    {
        $this->author = $author;
    }

    /**
     * Get charset.
     *
     * @return string Charset
     *
     * @since  1.0.0
     */
    public function getCharset() : string
    {
        return $this->charset;
    }

    /**
     * Set charset.
     *
     * @param string $charset Charset
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCharset(string $charset) /* : void */
    {
        $this->charset = $charset;
    }

    /**
     * Get description.
     *
     * @return string Descritpion
     *
     * @since  1.0.0
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description Meta description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription(string $description) /* : void */
    {
        $this->description = $description;
    }

    /**
     * Get language.
     *
     * @return string Language
     *
     * @since  1.0.0
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * Set language.
     *
     * @param string $language Language
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setLanguage(string $language) /* : void */
    {
        $this->language = $language;
    }

    /**
     * {@inheritdoc}
     */
    public function render() : string
    {
        return (count($this->keywords) > 0 ? '<meta name="keywords" content="' . implode(',', $this->keywords) . '">"' : '')
        . (isset($this->author) ? '<meta name="author" content="' . $this->author . '">' : '')
        . (isset($this->description) ? '<meta name="description" content="' . $this->description . '">' : '')
        . (isset($this->charset) ? '<meta charset="' . $this->charset . '">' : '')
        . '<meta name="generator" content="Orange Management">';
    }
}
