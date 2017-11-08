<span class="input">
<button type="button" data-action='[
    {
        "listener": "click", "action": [
            {"key": 1, "type": "dom.popup", "selector": "#acc-grp-tpl", "aniIn": "fadeIn", "id": "<?= $this->printHtml($this->getId()); ?>"},
            {"key": 2, "type": "message.request", "uri": "<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/account?filter=some&limit=10'); ?>", "method": "GET", "request_type": "json"},
            {"key": 3, "type": "dom.table.append", "id": "acc-table", "aniIn": "fadeIn", "data": [], "bindings": {"id": "id", "name": "name/0"}, "position": -1},
            {"key": 4, "type": "message.request", "uri": "<?= \phpOMS\Uri\UriFactory::build('/{/lang}/api/admin/account?filter=some&limit=10'); ?>", "method": "GET", "request_type": "json"},
            {"key": 5, "type": "dom.table.append", "id": "grp-table", "aniIn": "fadeIn", "data": [], "bindings": {"id": "id", "name": "name/0"}, "position": -1}
        ]
    }
]' formaction=""><i class="fa fa-book"></i></button>
<input type="text" list="<?= $this->printHtml($this->getId()); ?>-datalist" id="<?= $this->printHtml($this->getId()); ?>" name="receiver" placeholder="&#xf007; Guest" data-action='[
    {
        "key": 1, "listener": "keyup", "action": [
            {"key": 1, "type": "validate.keypress", "pressed": "!13!37!38!39!40"},
            {"key": 2, "type": "utils.timer", "id": "<?= $this->printHtml($this->getId()); ?>", "delay": 500, "resets": true},
            {"key": 3, "type": "dom.datalist.clear", "id": "<?= $this->printHtml($this->getId()); ?>-datalist"},
            {"key": 4, "type": "message.request", "uri": "{/base}/{/lang}/api/admin/find/account?search={#<?= $this->printHtml($this->getId()); ?>}", "method": "GET", "request_type": "json"},
            {"key": 5, "type": "dom.datalist.append", "id": "<?= $this->printHtml($this->getId()); ?>-datalist", "value": "id", "text": "name"}
        ]
    },
    {
        "key": 2, "listener": "keydown", "action" : [
            {"key": 1, "type": "validate.keypress", "pressed": "13|9"},
            {"key": 2, "type": "message.request", "uri": "{/base}/{/lang}/api/admin/find/account?search={#<?= $this->printHtml($this->getId()); ?>}", "method": "GET", "request_type": "json"},
            {"key": 3, "type": "dom.setvalue", "overwrite": false, "selector": "#<?= $this->printHtml($this->getId()); ?>-idlist", "value": "{0/id}", "data": ""},
            {"key": 4, "type": "dom.setvalue", "overwrite": false, "selector": "#<?= $this->printHtml($this->getId()); ?>-taglist", "value": "<span id=\"<?= $this->printHtml($this->getId()); ?>-taglist-{0/id}\" class=\"tag red\" data-id=\"{0/id}\"><i class=\"fa fa-times\"></i> {0/name/0}, {0/name/1}<span>", "data": ""},
            {"key": 5, "type": "dom.setvalue", "overwrite": true, "selector": "#<?= $this->printHtml($this->getId()); ?>", "value": "", "data": ""}
        ]
    }
]'<?= $this->isRequired() ? ' required' : ''; ?>>
<datalist id="<?= $this->printHtml($this->getId()); ?>-datalist"></datalist>
<input type="hidden" id="<?= $this->printHtml($this->getId()); ?>-idlist"></span>
<div class="box taglist" id="<?= $this->printHtml($this->getId()); ?>-taglist" data-action='[
    {
        "key": 1, "listener": "click", "selector": "#<?= $this->printHtml($this->getId()); ?>-taglist span fa", "action": [
            {"key": 1, "type": "dom.remove", "selector": "", "base": "self"},
            {"key": 2, "type": "dom.getvalue", "selector": "", "base": "self"},
            {"key": 3, "type": "dom.removevalue", "selector": "#<?= $this->printHtml($this->getId()); ?>-idlist", "data": ""}
        ]
    }
]'></div>