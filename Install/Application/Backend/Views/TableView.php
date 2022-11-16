<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   View
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Web\Backend\Views;

use Modules\Media\Models\Media;
use phpOMS\Message\RequestAbstract;
use phpOMS\Views\View;

/**
 * Basic view which can be used as basis for specific implementations.
 *
 * @package View
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class TableView extends View
{
    /**
     * Table id
     *
     * @var string
     * @since 1.0.0
     */
    public string $id = '';

    /**
     * Table title template
     *
     * @var string
     * @since 1.0.0
     */
    protected string $titleTemplate = '';

    /**
     * Table export template
     *
     * @var string
     * @since 1.0.0
     */
    protected string $exportTemplate = '';

    /**
     * Table export templates for different exports
     *
     * @var string
     * @since 1.0.0
     */
    protected array $exportTemplates = [];

    /**
     * Table column header template
     *
     * @var string
     * @since 1.0.0
     */
    protected string $columnHeaderElementTemplate = '';

    /**
     * Table filter template
     *
     * @var string
     * @since 1.0.0
     */
    protected string $filterTemplate = '';

    /**
     * Table sort template
     *
     * @var string
     * @since 1.0.0
     */
    protected string $sortTemplate = '';

    /**
     * Table export uri
     *
     * @var string
     * @since 1.0.0
     */
    public string $exportUri = '';

    /**
     * Table header counter template
     *
     * @var string
     * @since 1.0.0
     */
    protected int $counter = 0;

    /**
     * Table objects template
     *
     * @var string
     * @since 1.0.0
     */
    protected array $objects = [];

    /**
     * Set objects for the table
     *
     * @param array $objects Objects to be rendered in the table
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setObjects(array $objects) : void
    {
        $this->objects = $objects;
    }

    /**
     * Set title template
     *
     * @param string $template  Path to template
     * @param string $extension Template extension
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setTitleTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->titleTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    /**
     * Set export templates
     *
     * @param array $templates Export templates
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setExportTemplates(array $templates) : void
    {
        $this->exportTemplates = $templates;
    }

    /**
     * Add export template
     *
     * @param array $template Export template
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addExportTemplate(Media $template) : void
    {
        $this->exportTemplates[] = $template;
    }

    /**
     * Set column header template
     *
     * @param string $template  Path to template
     * @param string $extension Template extension
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setColumnHeaderElementTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->columnHeaderElementTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    /**
     * Set export template
     *
     * @param string $template  Path to template
     * @param string $extension Template extension
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setExportTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->exportTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    /**
     * Set filter template
     *
     * @param string $template  Path to template
     * @param string $extension Template extension
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setFilterTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->filterTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    /**
     * Set sort template
     *
     * @param string $template  Path to template
     * @param string $extension Template extension
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setSortTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->sortTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    /**
     * Define columns
     *
     * @param array $columns Column definitions
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setColumns(array $columns) : void
    {
        $this->columns = $columns;
    }

    /**
     * Get link to previous table page
     *
     * @param RequestAbstract $request     Request
     * @param null|object     $obj         Object from table element
     * @param bool            $hasPrevious Has previous page
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getPreviousLink(RequestAbstract $request, object $obj = null, bool $hasPrevious = false) : string
    {
        return $this->baseUri . (
            $obj === null
            ? '?element={?element}&sort_by={?sort_by}&sort_order={?sort_order}'
                . (!empty($request->getData('search'))
                ? '&search=' . $request->getData('search')
                : '')
            : '?{?}&id='
                . $obj->getId()
                . (!empty($request->getData('search'))
                    ? '&search=' . $request->getData('search')
                    : '')
                . ($request->getData('sort_by') !== 'id' && \property_exists($obj, $request->getData('sort_by') ?? '')
                    ? '&subid=' . $obj->{$request->getData('sort_by')}
                    : '')
                . '&ptype=p'
        );
    }

    /**
     * Get link to next table page
     *
     * @param RequestAbstract $request Request
     * @param null|object     $obj     Object from table element
     * @param bool            $hasNext Has next page
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getNextLink(RequestAbstract $request, object $obj = null, $hasNext = false) : string
    {
        return $this->baseUri . (
            $obj === null
            ? '?element={?element}&sort_by={?sort_by}&sort_order={?sort_order}'
                . (!empty($request->getData('search'))
                ? '&search=' . $request->getData('search')
                : '')
            : '?{?}&id='
                . ($hasNext ? $obj->getId() : $request->getData('id'))
                . (!empty($request->getData('search'))
                    ? '&search=' . $request->getData('search')
                    : '')
                . ($request->getData('sort_by') !== 'id' && \property_exists($obj, $request->getData('sort_by') ?? '')
                    ? '&subid=' . $obj->{$request->getData('sort_by')}
                    : '')
                . '&ptype=n'
        );
    }

    /**
     * Get link for GET search
     *
     * @param string $id Element id
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getSearchLink(
        string $id
    ) : string
    {
        return $this->baseUri . '?sort_by={?sort_by}&sort_order={?sort_order}';
    }

    /**
     * {@inheritdoc}
     */
    public function render(mixed ...$data) : string
    {
        $this->id = $data[0];
        return parent::render();
    }

    /**
     * Render table title
     *
     * @param mixed ...$data Data to pass to renderer
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function renderTitle(mixed ...$data) : string
    {
        $data[0] ??= 'ERROR'; // string
        $data[1] ??= true; // render search

        return $this->renderTemplate($this->titleTemplate, ...$data);
    }

    /**
     * Render table header
     *
     * @param mixed ...$data Data to pass to renderer
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function renderHeaderElement(mixed ...$data) : string
    {
        ++$this->counter;

        $data[0] ??= ''; // model name
        $data[1] ??= 'ERROR'; // string
        $data[2] ??= 'text'; // filter type, '' = don't render
        $data[3] ??= []; // filter options
        $data[4] ??= true; // render sort
        $data[5] ??= true; // render filter
        $data[6] ??= true; // render search

        return $this->renderTemplate($this->columnHeaderElementTemplate, ...$data);
    }

    /**
     * Render table export
     *
     * @param mixed ...$data Data to pass to renderer
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function renderExport(mixed ...$data) : string
    {
        return $this->renderTemplate($this->exportTemplate, ...$data);
    }

    /**
     * Render table filter
     *
     * @param mixed ...$data Data to pass to renderer
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function renderFilter(mixed ...$data) : string
    {
        return $this->renderTemplate($this->filterTemplate, ...$data);
    }

    /**
     * Render table sort
     *
     * @param mixed ...$data Data to pass to renderer
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function renderSort(mixed ...$data) : string
    {
        return $this->renderTemplate($this->sortTemplate, ...$data);
    }
}
