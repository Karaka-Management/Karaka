<table class="table red">
    <caption><?= $this->getHtml('Tasks', 'Tasks') ?></caption>
    <thead>
        <td><?= $this->getHtml('Status', 'Tasks') ?>
        <td><?= $this->getHtml('Due', 'Tasks') ?>
        <td class="full"><?= $this->getHtml('Title', 'Tasks') ?>
    <tfoot>
    <tbody>
    <?php $c = 0; foreach ($this->tasks as $key => $task) : $c++;
    $url = \phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/task/single?{?}&id=' . $task->getId());
    $color = 'darkred';
    if ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::DONE) { $color = 'green'; }
    elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::OPEN) { $color = 'darkblue'; }
    elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::WORKING) { $color = 'purple'; }
    elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::CANCELED) { $color = 'red'; }
    elseif ($task->getStatus() === \Modules\Tasks\Models\TaskStatus::SUSPENDED) { $color = 'yellow'; } ;?>
        <tr data-href="<?= $url; ?>">
            <td><a href="<?= $url; ?>"><span class="tag <?= $this->printHtml($color); ?>"><?= $this->getHtml('S' . $task->getStatus(), 'Tasks') ?></span></a>
            <td><a href="<?= $url; ?>"><?= $this->printHtml($task->getDue()->format('Y-m-d H:i')); ?></a>
            <td><a href="<?= $url; ?>"><?= $this->printHtml($task->getTitle()); ?></a>
    <?php endforeach; if ($c == 0) : ?>
    <tr><td colspan="6" class="empty"><?= $this->getHtml('Empty', 0, 0); ?>
    <?php endif; ?>
</table>