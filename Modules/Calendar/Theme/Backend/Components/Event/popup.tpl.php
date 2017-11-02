<template id="calendar-event-popup-tpl">
    <section id="calendar-event-popup" class="box w-50" style="z-index: 9; position: absolute; margin: 0 auto; left: 50%; top: 50%; transform: translate(-50%, -50%);">
        <header><h1><?= $this->getHtml('Event', 'Calendar') ?></h1></header>

        <div class="inner">
            <form>
                <table class="layout">
                    <tr><td><label for="iTitle">Title</label>
                    <tr><td><input type="text" id="">
                    <tr><td><label for="iTitle">Description</label>
                    <tr><td><textarea></textarea>
                    <tr><td><label for="iTitle">To</label>
                    <tr><td><input type="text" id="">
                    <tr><td><label for="iTitle">Files</label>
                    <tr><td><input type="text" id="">
                    <tr><td><button type="button" data-action='[
                                    {
                                        "listener": "click", "action": [
                                            {"key": 1, "type": "dom.remove", "tpl": "calendar-event-popup", "aniOut": "fadeOut"}
                                        ]
                                    }
                                ]'><?= $this->getHtml('Close', 'Calendar') ?></button>
                </table>
            </form>
        </div>
    </section>
</template>