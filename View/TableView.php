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

namespace View;

use Modules\Media\Models\Media;
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

    protected string $exportTemplate = '';

    protected array $exportTemplates = [];

    protected string $columnHeaderElementTemplate = '';

    protected string $filterTemplate = '';

    protected string $sortTemplate = '';

    public string $exportUri = '';

    protected int $counter = 0;

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

    /**
     * {@inheritdoc}
     */
    public function render(...$data) : string
    {
        $this->id = $data[0];
        return parent::render();
    }

    public function renderHeaderElement(...$data) : string
    {
        ++$this->counter;

        $data[0] ??= 'ERROR';
        $data[1] ??= 'text';
        $data[2] ??= [];

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
