<div id="calendar" class="m-calendar m-calendar-mini" data-action='[
    {
        "listener": "click", "selector": "#calendar span.tag", "action": [
{"key": 1, "type": "dom.popup", "tpl": "calendar-event-popup-tpl", "aniIn": "fadeIn"}
        ]
    }
]'>
    <div class="box wf-100">
        <ul class="weekdays green">
            <li><?= $this->getHtml('Sunday', 'Calendar'); ?>
            <li><?= $this->getHtml('Monday', 'Calendar'); ?>
            <li><?= $this->getHtml('Tuesday', 'Calendar'); ?>
            <li><?= $this->getHtml('Wednesday', 'Calendar'); ?>
            <li><?= $this->getHtml('Thursday', 'Calendar'); ?>
            <li><?= $this->getHtml('Friday', 'Calendar'); ?>
            <li><?= $this->getHtml('Saturday', 'Calendar'); ?>
        </ul>
        <?php $current = $this->calendar->getDate()->getMonthCalendar(0); $isActiveMonth = false;
        for ($i = 0; $i < 6; $i++) : ?>
        <ul class="days">
            <?php for ($j = 0; $j < 7; $j++) : 
                $isActiveMonth = ((int) $current[$i*7+$j]->format('d') === 1) ? !$isActiveMonth : $isActiveMonth; 
            ?>
                <?php if ($isActiveMonth) :?>
                <li class="day<?= $this->calendar->hasEventOnDate($current[$i*7+$j]) ? ' has-event' : '';?>">
                    <div class="date"><?= $current[$i*7+$j]->format('d'); ?></div>
                        <?php else: ?>
                <li class="day other-month<?= $this->calendar->hasEventOnDate($current[$i*7+$j]) ? ' has-event' : '';?>">
                    <div class="date"><?= $current[$i*7+$j]->format('d'); ?></div>
                <?php endif; ?>
            <?php endfor; ?>
            </li>
        </ul>
        <?php endfor;?>
    </div>
</div>