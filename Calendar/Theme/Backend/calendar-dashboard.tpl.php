<?php
$calendar = $this->getData('calendar');
?>
<div class="row">
    <div class="col-xs-12 col-md-9">
        <div class="box wf-100">
            <ul class="btns floatLeft">
                <li><a href="<?= $this->printHtml(\phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/calendar/dashboard?date=' . $calendar->getDate()->createModify(0, -1, 0)->format('Y-m-d'))); ?>"><i class="fa fa-arrow-left"></i></a>
                <li><a href="<?= $this->printHtml(\phpOMS\Uri\UriFactory::build('{/base}/{/lang}/backend/calendar/dashboard?date=' . $calendar->getDate()->createModify(0, 1, 0)->format('Y-m-d'))); ?>"><i class="fa fa-arrow-right"></i></a>
            </ul>
            <ul class="btns floatRight">
                <li><a href=""><?= $this->getHtml('Day'); ?></a>
                <li><a href=""><?= $this->getHtml('Week'); ?></a>
                <li><a href=""><?= $this->getHtml('Month'); ?></a>
                <li><a href=""><?= $this->getHtml('Year'); ?></a>
            </ul>
        </div>
        <div class="box wf-100">
            <div id="calendar" class="m-calendar" data-action='[
                {
                    "listener": "click", "selector": "#calendar span.tag", "action": [
                        {"key": 1, "type": "dom.popup", "tpl": "calendar-event-popup-tpl", "aniIn": "fadeIn"}
                    ]
                }
            ]'>
                <ul class="weekdays green">
                    <li><?= $this->getHtml('Sunday'); ?>
                    <li><?= $this->getHtml('Monday'); ?>
                    <li><?= $this->getHtml('Tuesday'); ?>
                    <li><?= $this->getHtml('Wednesday'); ?>
                    <li><?= $this->getHtml('Thursday'); ?>
                    <li><?= $this->getHtml('Friday'); ?>
                    <li><?= $this->getHtml('Saturday'); ?>
                </ul>
                <?php $current = $calendar->getDate()->getMonthCalendar(0); $isActiveMonth = false;
                for ($i = 0; $i < 6; $i++) : ?>
                <ul class="days">
                    <?php for ($j = 0; $j < 7; $j++) : 
                        $isActiveMonth = ((int) $current[$i*7+$j]->format('d') === 1) ? !$isActiveMonth : $isActiveMonth; 
                    ?>
                        <?php if ($isActiveMonth) :?>
                        <li class="day">
                            <div class="date"><?= $current[$i*7+$j]->format('d'); ?></div>
                                <?php else: ?>
                        <li class="day other-month">
                            <div class="date"><?= $current[$i*7+$j]->format('d'); ?></div>
                                <?php endif; ?>
                            <?php
                            $events = $calendar->getEventByDate($current[$i*7+$j]);
                            foreach ($events as $event) : ?> 
                                <div id="event-tag-<?= $this->printHtml($event->getId()); ?>" class="event">
                        <div class="event-desc"><?= $this->printHtml($event->getName()); ?></div>
                        <div class="event-time">2:00pm to 5:00pm</div>
                                </div>
                            <?php endforeach; ?>
                        <?php endfor; ?>
                    </li>
                </ul>
                <?php endfor;?>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-3">
        <section class="box wf-100">
            <header><h1>Title</h1></header>

            <div class="inner">
                <form>
                    <table class="layout wf-100">
                        <tr>
                            <td><label>Layout</label>
                        <tr>
                            <td><select>
                                    <option>
                                </select>
                    </table>
                </form>
            </div>
        </section>

        <section class="box wf-100">
            <header><h1>Calendars</h1></header>

            <div class="inner">
                <ul class="boxed">
                    <li><i class="fa fa-times warning"></i> <span class="check"><input type="checkbox" id="iDefault" checked><label for="iDefault">Default</label></span><i class="fa fa-cogs floatRight"></i>
                </ul>
                <div class="spacer"></div>
                <button><i class="fa fa-calendar-plus-o"></i> <?= $this->getHtml('Add', 0, 0); ?></button> <button><i class="fa fa-calendar-check-o"></i> <?= $this->getHtml('Create', 0, 0); ?></button>
            </div>
        </section>
    </div>
</div>

<menu type="context" id="calendar-day-menu">
    <menuitem label="<?= $this->getHtml('NewEvent'); ?>"></menuitem>
</menu>

<menu type="context" id="calendar-event-menu">
    <menuitem label="Edit"></menuitem>
    <menuitem label="Accept" disabled></menuitem>
    <menuitem label="Re-Schedule"></menuitem>
    <menuitem label="Decline"></menuitem>
    <menuitem label="Delete"></menuitem>
</menu>

<?= $this->getData('calendarEventPopup')->render('iCalendarEvent'); ?>