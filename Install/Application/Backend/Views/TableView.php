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
    public string $id = '';

    protected string $titleTemplate = '';

    protected string $exportTemplate = '';

    protected array $exportTemplates = [];

    protected string $columnHeaderElementTemplate = '';

    protected string $filterTemplate = '';

    protected string $sortTemplate = '';

    public string $exportUri = '';

    protected int $counter = 0;

    public function setTitleTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->titleTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    public function setExportTemplates(array $templates) : void
    {
        $this->exportTemplates = $templates;
    }

    public function addExportTemplate(Media $template) : void
    {
        $this->exportTemplates[] = $template;
    }

    public function setColumnHeaderElementTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->columnHeaderElementTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    public function setExportTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->exportTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    public function setFilterTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->filterTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    public function setSortTemplate(string $template, string $extension = 'tpl.php') : void
    {
        $this->sortTemplate = self::BASE_PATH . $template . '.' . $extension;
    }

    public function setColumns(array $columns) : void
    {
        $this->columns = $columns;
    }

    public function getPreviousLink(
        string $base,
        RequestAbstract $request,
        object $obj = null,
        bool $hasPrevious = false
    ) : string
    {
        return $base . (
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

    public function getNextLink(
        string $base,
        RequestAbstract $request,
        object $obj = null,
        $hasNext = false
    ) : string
    {
        return $base . (
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

    public function getSearchLink(
        string $base,
        string $id
    ) : string
    {
        return $base . '?sort_by={?sort_by}&sort_order={?sort_order}';
    }

    /**
     * {@inheritdoc}
     */
    public function render(...$data) : string
    {
        $this->id = $data[0];
        return parent::render();
    }

    public function renderTableTitle(...$data) : string
    {
        $data[0] ??= 'ERROR'; // string
        $data[1] ??= false; // has search
        $data[2] ??= false; // has export

        return $this->renderTemplate($this->titleTemplate, ...$data);
    }

    public function renderHeaderElement(...$data) : string
    {
        ++$this->counter;

        $data[0] ??= ''; // model name
        $data[1] ??= 'ERROR'; // string
        $data[2] ??= 'text'; // filter type, '' = don't render
        $data[3] ??= []; // filter options
        $data[4] ??= true;

        return $this->renderTemplate($this->columnHeaderElementTemplate, ...$data);
    }

    public function renderExport(...$data) : string
    {
        return $this->renderTemplate($this->exportTemplate, ...$data);
    }

    public function renderFilter(...$data) : string
    {
        return $this->renderTemplate($this->filterTemplate, ...$data);
    }

    public function renderSort(...$data) : string
    {
        return $this->renderTemplate($this->sortTemplate, ...$data);
    }
}
