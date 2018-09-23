/** global: jsOMS */
const MOUSE_EVENTS = [
    {
        'element': 'nav-side',
        'type': jsOMS.UI.Input.Mouse.EventType.CONTEXT,
        'button': jsOMS.UI.Input.Mouse.ClickType.RIGHT,
        'callback': function () {console.log('right clicked');},
        'exact': true
    }, {
        'element': 'nav-side',
        'type': jsOMS.UI.Input.Mouse.EventType.LONGPRESS,
        'button': jsOMS.UI.Input.Mouse.ClickType.LEFT,
        'callback': function () {console.log('left clicked');},
        'exact': false
    }
];