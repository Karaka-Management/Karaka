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

namespace phpOMS\Utils\Git;

use phpOMS\System\File\PathException;
use phpOMS\Utils\StringUtils;

/**
 * Repository class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Repository
{
    /**
     * Repository path.
     *
     * @var string
     * @since 1.0.0
     */
    private $path = '';

    /**
     * Repository name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Bare repository.
     *
     * @var bool
     * @since 1.0.0
     */
    private $bare = false;

    /**
     * Current branch.
     *
     * @var Branch
     * @since 1.0.0
     */
    private $branch = null;

    /**
     * Constructor
     *
     * @param string $path Repository path
     *
     * @since  1.0.0
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
        $this->branch = $this->getActiveBranch();
    }

    /**
     * Set repository path.
     *
     * @param string $path Path to repository
     *
     * @throws PathException
     *
     * @since  1.0.0
     */
    private function setPath(string $path) /* : void */
    {
        if (!is_dir($path)) {
            throw new PathException($path);
        }

        $this->path = realpath($path);

        if ($this->path === false) {
            throw new PathException($path);
        }

        if (file_exists($this->path . '/.git') && is_dir($this->path . '/.git')) {
            $this->bare = false;
        } elseif (is_file($this->path . '/config')) { // Is this a bare repo?
            $parseIni = parse_ini_file($this->path . '/config');

            if ($parseIni['bare']) {
                $this->bare = true;
            }
        }
    }

    /**
     * Get active Branch.
     *
     * @return Branch
     *
     * @since  1.0.0
     */
    public function getActiveBranch() : Branch
    {
        if (!isset($this->branch)) {
            $branches = $this->getBranches();
            $active   = preg_grep('/^\*/', $branches);
            reset($active);

            $this->branch = new Branch(current($active));
        }

        return $this->branch;
    }

    /**
     * Get all branches.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getBranches() : array
    {
        $branches = $this->run('branch');
        $result   = [];

        foreach ($branches as $key => $branch) {
            $branch = trim($branch, '* ');

            if ($branch !== '') {
                $result[] = $branch;
            }
        }

        return $result;
    }

    /**
     * Run git command.
     *
     * @param string $cmd Command to run
     *
     * @return array
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function run(string $cmd) : array
    {
        if (strtolower(substr(PHP_OS, 0, 3)) == 'win') {
            $cmd = 'cd ' . escapeshellarg(dirname(Git::getBin())) . ' && ' . basename(Git::getBin()) . ' -C ' . escapeshellarg($this->path) . ' ' . $cmd;
        } else {
            $cmd = escapeshellarg(Git::getBin()) . ' -C ' . escapeshellarg($this->path) . ' ' . $cmd;
        }

        $pipes = [];
        $desc  = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $resource = proc_open($cmd, $desc, $pipes, $this->path, null);
        $stdout   = stream_get_contents($pipes[1]);
        $stderr   = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));

        if ($status == -1) {
            throw new \Exception($stderr);
        }

        return $this->parseLines(trim($stdout));
    }

    /**
     * Parse lines.
     *
     * @param string $lines Result of git command
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function parseLines(string $lines) : array
    {
        $lineArray = preg_split('/\r\n|\n|\r/', $lines);
        $lines     = [];

        foreach ($lineArray as $key => $line) {
            $temp = preg_replace('/\s+/', ' ', trim($line, ' '));

            if (!empty($temp)) {
                $lines[] = $temp;
            }
        }

        return $lines;
    }

    /**
     * Create repository
     *
     * @param string $source Create repository from source (optional, can be remote)
     * @param bool   $bare   Bare repository
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function create(string $source = null, bool $bare = false)
    {
        if (!is_dir($this->path) || file_exists($this->path . '/.git')) {
            throw new \Exception('Already repository');
        }

        if (isset($source)) {
            $this->clone($source);
        } else {
            $this->init($bare);
        }
    }

    /**
     * Get status.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function status() : string
    {
        return implode("\n", $this->run('status'));
    }

    /**
     * Files to add to commit.
     *
     * @param string|array $files Files to commit
     *
     * @return string
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function add($files = '*') : string
    {
        if (is_array($files)) {
            $files = '"' . implode('" "', $files) . '"';
        } elseif (!is_string($files)) {
            throw new \Exception('Wrong type');
        }

        return implode("\n", $this->run('add ' . $files . ' -v'));
    }

    /**
     * Remove file(s) from repository
     *
     * @param string|array $files  Files to remove
     * @param bool         $cached ?
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     *
     * @since  1.0.0
     */
    public function rm($files = '*', bool $cached = false) : string
    {
        if (is_array($files)) {
            $files = '"' . implode('" "', $files) . '"';
        } elseif (!is_string($files)) {
            throw new \InvalidArgumentException('Wrong type for $files.');
        }

        return implode("\n", $this->run('rm ' . ($cached ? '--cached ' : '') . $files));
    }

    /**
     * Commit files.
     *
     * @param Commit $commit Commit to commit
     * @param bool   $all    Commit all
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function commit(Commit $commit, $all = true) : string
    {
        return implode("\n", $this->run('commit ' . ($all ? '-av' : '-v') . ' -m ' . escapeshellarg($commit->getMessage())));
    }

    /**
     * Clone repository to different directory
     *
     * @param string $target Target clone directory
     *
     * @return string
     *
     * @throws PathException in case the target is not a valid directory
     *
     * @since  1.0.0
     */
    public function cloneTo(string $target) : string
    {
        if (!is_dir($target)) {
            throw new PathException($target);
        }

        return implode("\n", $this->run('clone --local ' . $this->path . ' ' . $target));
    }

    /**
     * Clone repository to current directory
     *
     * @param string $source Source repository to clone
     *
     * @return string
     *
     * @throws PathException in case the source repository is not valid
     *
     * @since  1.0.0
     */
    public function cloneFrom(string $source) : string
    {
        if (!is_dir($source)) {
            throw new PathException($source);
        }

        // todo: is valid git repository?

        return implode("\n", $this->run('clone --local ' . $source . ' ' . $this->path));
    }

    /**
     * Clone remote repository to current directory
     *
     * @param string $source Source repository to clone
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function cloneRemote(string $source) : string
    {
        // todo: is valid remote git repository?

        return implode("\n", $this->run('clone ' . $source . ' ' . $this->path));
    }

    /**
     * Clean.
     *
     * @param bool $dirs  Directories?
     * @param bool $force Force?
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function clean(bool $dirs = false, bool $force = false) : string
    {
        return implode("\n", $this->run('clean' . ($force ? ' -f' : '') . ($dirs ? ' -d' : '')));
    }

    /**
     * Create local branch.
     *
     * @param Branch $branch Branch
     * @param bool   $force  Force?
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function createBranch(Branch $branch, bool $force = false) : string
    {
        return implode("\n", $this->run('branch ' . ($force ? '-D' : '-d') . ' ' . $branch->getName()));
    }

    /**
     * Get repository name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        if (empty($this->name)) {
            $path       = $this->getDirectoryPath();
            $path       = str_replace('\\', '/', $path);
            $path       = explode('/', $path);
            $this->name = $path[count($path) - ($this->bare ? 1 : 2)];
        }

        return $this->name;
    }

    /**
     * Get directory path.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDirectoryPath() : string
    {
        return $this->bare ? $this->path : $this->path . '/.git';
    }

    /**
     * Get all remote branches.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getBranchesRemote() : array
    {
        $branches = $this->run('branch -r');
        $result   = [];

        foreach ($branches as $key => $branch) {
            $branch = trim($branch, '* ');

            if ($branch !== '') {
                $result[] = $branch;
            }
        }

        return $result;
    }

    /**
     * Checkout.
     *
     * @param Branch $branch Branch to checkout
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function checkout(Branch $branch) : string
    {
        $result       = implode("\n", $this->run('checkout ' . $branch->getName()));
        $this->branch = null;

        return $result;
    }

    /**
     * Merge with branch.
     *
     * @param Branch $branch Branch to merge from
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function merge(Branch $branch) : string
    {
        return implode("\n", $this->run('merge ' . $branch->getName() . ' --no-ff'));
    }

    /**
     * Fetch.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function fetch() : string
    {
        return implode("\n", $this->run('fetch'));
    }

    /**
     * Create tag.
     *
     * @param Tag $tag Tag to create
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function createTag(Tag $tag) : string
    {
        return implode("\n", $this->run('tag -a ' . $tag->getName() . ' -m ' . escapeshellarg($tag->getMessage())));
    }

    /**
     * Get all tags.
     *
     * @param string $pattern Tag pattern
     *
     * @return Tag[]
     *
     * @since  1.0.0
     */
    public function getTags(string $pattern = '') : array
    {
        $pattern = empty($pattern) ? ' -l ' . $pattern : '';
        $lines   = $this->run('tag' . $pattern);
        $tags    = [];

        foreach ($lines as $key => $tag) {
            $tags[$tag] = new Tag($tag);
        }

        return $tags;
    }

    /**
     * Push.
     *
     * @param string $remote Remote repository
     * @param Branch $branch Branch to pull
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function push(string $remote, Branch $branch) : string
    {
        $remote = escapeshellarg($remote);

        return implode("\n", $this->run('push --tags ' . $remote . ' ' . $branch->getName()));
    }

    /**
     * Pull.
     *
     * @param string $remote Remote repository
     * @param Branch $branch Branch to pull
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function pull(string $remote, Branch $branch) : string
    {
        $remote = escapeshellarg($remote);

        return implode("\n", $this->run('pull ' . $remote . ' ' . $branch->getName()));
    }

    /**
     * Set repository description.
     *
     * @param string $description Repository description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription(string $description) /* : void */
    {
        file_put_contents($this->getDirectoryPath(), $description);
    }

    /**
     * Get repository description.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDescription() : string
    {
        return file_get_contents($this->getDirectoryPath() . '/description');
    }

    /**
     * Count files in repository.
     *
     * @return int
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function countFiles() : int
    {
        $lines = $this->run('ls-files');

        return count($lines);
    }

    /**
     * Get LOC.
     *
     * @param array $extensions Extensions whitelist
     *
     * @return int
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function getLOC(array $extensions = ['*']) : int
    {
        $lines = $this->run('ls-files');
        $loc   = 0;

        foreach ($lines as $line) {
            if ($extensions[0] !== '*' && !StringUtils::endsWith($line, $extensions)) {
                continue;
            }

            if (!file_exists($path = $this->getDirectoryPath() . ($this->bare ? '/' : '/../') . $line)) {
                return 0;
            }

            $fh = fopen($path, 'r');

            if (!$fh) {
                return 0;
            }

            while (!feof($fh)) {
                fgets($fh);
                $loc++;
            }

            fclose($fh);
        }

        return $loc;
    }

    /**
     * Get contributors.
     *
     * @param \DateTime $start Start date
     * @param \DateTime $end   End date
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getContributors(\DateTime $start = null, \DateTime $end = null) : array
    {
        if (!isset($start)) {
            $start = new \DateTime('1970-12-31');
        }

        if (!isset($end)) {
            $end = new \DateTime('now');
        }

        $lines        = $this->run('shortlog -s -n --since="' . $start->format('Y-m-d') . '" --before="' . $end->format('Y-m-d') . '" --all');
        $contributors = [];

        foreach ($lines as $line) {
            preg_match('/^[0-9]*/', $line, $matches);

            $contributor = new Author(substr($line, strlen($matches[0]) + 1));
            $contributor->setCommitCount($this->getCommitsCount($start, $end)[$contributor->getName()]);

            $addremove = $this->getAdditionsRemovalsByContributor($contributor, $start, $end);
            $contributor->setAdditionCount($addremove['added']);
            $contributor->setRemovalCount($addremove['removed']);

            $contributors[] = $contributor;
        }

        return $contributors;
    }

    /**
     * Count commits.
     *
     * @param \DateTime $start Start date
     * @param \DateTime $end   End date
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getCommitsCount(\DateTime $start = null, \DateTime $end = null) : array
    {
        if (!isset($start)) {
            $start = new \DateTime('1970-12-31');
        }

        if (!isset($end)) {
            $end = new \DateTime('now');
        }

        $lines   = $this->run('shortlog -s -n --since="' . $start->format('Y-m-d') . '" --before="' . $end->format('Y-m-d') . '" --all');
        $commits = [];

        foreach ($lines as $line) {
            preg_match('/^[0-9]*/', $line, $matches);

            $commits[substr($line, strlen($matches[0]) + 1)] = (int) $matches[0];
        }

        return $commits;
    }

    /**
     * Get additions and removals from contributor.
     *
     * @param Author    $author Author
     * @param \DateTime $start  Start date
     * @param \DateTime $end    End date
     *
     * @return array ['added' => ?, 'removed'=> ?]
     *
     * @since  1.0.0
     */
    public function getAdditionsRemovalsByContributor(Author $author, \DateTime $start = null, \DateTime $end = null) : array
    {
        $addremove = ['added' => 0, 'removed' => 0];
        $lines     = $this->run('log --author=' . escapeshellarg($author->getName()) . ' --since="' . $start->format('Y-m-d') . '" --before="' . $end->format('Y-m-d') . '" --pretty=tformat: --numstat');

        foreach ($lines as $line) {
            $nums = explode(' ', $line);

            $addremove['added'] += $nums[0];
            $addremove['removed'] += $nums[1];
        }

        return $addremove;
    }

    /**
     * Get remote.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getRemote() : string
    {
        return $this->run('config --get remote.origin.url');
    }

    /**
     * Get commits by author.
     *
     * @param \DateTime $start  Commits from
     * @param \DateTime $end    Commits to
     * @param Author    $author Commits by author
     *
     * @return Commit[]
     *
     * @since  1.0.0
     */
    public function getCommitsBy(\DateTime $start = null, \DateTime $end = null, Author $author = null) : array
    {
        if (!isset($start)) {
            $start = new \DateTime('1970-12-31');
        }

        if (!isset($end)) {
            $end = new \DateTime('now');
        }

        if (!isset($author)) {
            $author = '';
        } else {
            $author = ' --author=' . escapeshellarg($author->getName()) . '';
        }

        $lines   = $this->run('git log --before="' . $end->format('Y-m-d') . '" --after="' . $start->format('Y-m-d') . '"' . $author . ' --reverse --date=short');
        $count   = count($lines);
        $commits = [];

        for ($i = 0; $i < $count; $i++) {
            $match = preg_match('/[0-9ABCDEFabcdef]{40}/', $lines[$i], $matches);

            if ($match !== false && $match !== 0) {
                $commit                    = $this->getCommit($matches[0]);
                $commits[$commit->getId()] = $commit;
            }
        }

        return $commits;
    }

    /**
     * Get commit by id.
     *
     * @param string $commit Commit id
     *
     * @return Commit
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function getCommit(string $commit) : Commit
    {
        $lines = $this->run('show --name-only ' . escapeshellarg($commit));
        $count = count($lines);

        if (empty($lines)) {
            // todo: return null commit
            return new Commit();
        }

        preg_match('/[0-9ABCDEFabcdef]{40}/', $lines[0], $matches);

        if (!isset($matches[0]) || strlen($matches[0]) !== 40) {
            throw new \Exception('Invalid commit id');
        }

        if (StringUtils::startsWith($lines[1], 'Merge')) {
            return new Commit();
        }

        // todo: validate if array values are all initialized
        $author = explode(':', $lines[1]);
        $author = explode('<', trim($author[1]));
        $date   = substr($lines[2], 6);

        $commit = new Commit($matches[0]);
        $commit->setAuthor(new Author(trim($author[0] ?? ''), rtrim($author[1] ?? '', '>')));
        $commit->setDate(new \DateTime(trim($date ?? 'now')));
        $commit->setMessage($lines[3]);
        $commit->setTag(new Tag());
        $commit->setRepository($this);
        $commit->setBranch($this->branch);

        for ($i = 4; $i < $count; $i++) {
            $commit->addFile($lines[$i]);
        }

        return $commit;
    }

    /**
     * Get newest commit.
     *
     * @param int $limit Limit of commits
     *
     * @return Commit
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function getNewest(int $limit = 1) : Commit
    {
        $lines = $this->run('log -n ' . $limit);

        if (empty($lines)) {
            // todo: return nullcommit
            return new Commit();
        }

        preg_match('/[0-9ABCDEFabcdef]{40}/', $lines[0], $matches);

        if (!isset($matches[0]) || strlen($matches[0]) !== 40) {
            throw new \Exception('Invalid commit id');
        }

        return $this->getCommit($matches[0]);
    }
}
