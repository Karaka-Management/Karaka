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

namespace phpOMS\Utils\Git;

/**
 * Gray encoding class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Commit
{
    /**
     * Hash.
     *
     * @var string
     * @since 1.0.0
     */
    private $id = '';

    /**
     * Author.
     *
     * @var Author
     * @since 1.0.0
     */
    private $author = null;

    /**
     * Branch.
     *
     * @var Branch
     * @since 1.0.0
     */
    private $branch = null;

    /**
     * Tag.
     *
     * @var Tag
     * @since 1.0.0
     */
    private $tag = null;

    /**
     * Commit date.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $date = null;

    /**
     * Repository.
     *
     * @var Repository
     * @since 1.0.0
     */
    private $repository = null;

    /**
     * Commit message.
     *
     * @var string
     * @since 1.0.0
     */
    private $message = '';

    /**
     * Files.
     *
     * @var string[]
     * @since 1.0.0
     */
    private $files = [];

    /**
     * Constructor
     *
     * @param string $id Commit hash
     *
     * @since  1.0.0
     */
    public function __construct(string $id = '')
    {
        $this->id     = $id;
        $this->author = new Author();
        $this->branch = new Branch();
        $this->tag    = new Tag();
        $this->repository = new Repository(realpath(__DIR__ . '/../../../../../'));
    }

    /**
     * Get commit id.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Add file to commit.
     *
     * @param string $path File path
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function addFile(string $path) : bool
    {
        if (!isset($this->files[$path])) {
            $this->files[$path] = [];

            return true;
        }

        return false;
    }

    /**
     * Get commit message.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Set commit message.
     *
     * @param string $message Commit message
     *
     * @since  1.0.0
     */
    public function setMessage(string $message) /* : void */
    {
        $this->message = $message;
    }

    /**
     * Get files of this commit.
     *
     * @return string[]
     *
     * @since  1.0.0
     */
    public function getFiles() : array
    {
        return $this->files;
    }

    /**
     * Get files of this commit.
     *
     * @param string $path File path
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function removeFile(string $path) : bool
    {
        if (isset($this->files[$path])) {
            unset($this->files[$path]);

            return true;
        }

        return false;
    }

    /**
     * Get commit author.
     *
     * @return Author
     *
     * @since  1.0.0
     */
    public function getAuthor() : Author
    {
        return $this->author;
    }

    /**
     * Set commit author.
     *
     * @param Author $author Commit author
     *
     * @since  1.0.0
     */
    public function setAuthor(Author $author) /* : void */
    {
        $this->author = $author;
    }

    /**
     * Get commit branch.
     *
     * @return Branch
     *
     * @since  1.0.0
     */
    public function getBranch() : Branch
    {
        return $this->branch;
    }

    /**
     * Set commit branch.
     *
     * @param Branch $branch Commit branch
     *
     * @since  1.0.0
     */
    public function setBranch(Branch $branch) /* : void */
    {
        $this->branch = $branch;
    }

    /**
     * Get commit tag.
     *
     * @return Tag
     *
     * @since  1.0.0
     */
    public function getTag() : Tag
    {
        return $this->tag;
    }

    /**
     * Set commit tag.
     *
     * @param Tag $tag Commit tag
     *
     * @since  1.0.0
     */
    public function setTag(Tag $tag) /* : void */
    {
        $this->tag = $tag;
    }

    /**
     * Get commit date.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getDate() : \DateTime
    {
        return $this->date ?? new \DateTime('now');
    }

    /**
     * Set commit date.
     *
     * @param \DateTime $date Commit date
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDate(\DateTime $date) /* : void */
    {
        $this->date = $date;
    }

    /**
     * Get commit repository.
     *
     * @return Repository
     *
     * @since  1.0.0
     */
    public function getRepository() : Repository
    {
        return $this->repository;
    }

    /**
     * Set commit repository.
     *
     * @param Repository $repository Commit repository
     *
     * @since  1.0.0
     */
    public function setRepository(Repository $repository) /* : void */
    {
        $this->repository = $repository;
    }

    /**
     * Add change.
     *
     * @param string $path File path
     * @param int    $line Line number
     * @param string $old  Old line
     * @param string $new  New line
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function addChange(string $path, int $line, string $old, string $new) /* : void */
    {
        if (!isset($this->files[$path])) {
            throw new \Exception();
        }

        if (!isset($this->files[$path][$line])) {
            $this->files[$path][$line] = ['old' => $old, 'new' => $new];
        } else {
            throw new \Exception();
        }
    }
}
