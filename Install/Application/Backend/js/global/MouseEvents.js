import { EventType } from '../../../../jsOMS/UI/Input/Mouse/EventType.js';
import { ClickType } from '../../../../jsOMS/UI/Input/Mouse/ClickType.js';

/** global: jsOMS */
export const MOUSE_EVENTS = [
    {
        'element': 'nav-side',
        'type': EventType.CONTEXT,
        'button': ClickType.RIGHT,
        'callback': function () { window.omsApp.logger.log('right clicked'); },
        'exact': true
    }, {
        'element': 'nav-side',
        'type': EventType.LONGPRESS,
        'button': ClickType.LEFT,
        'callback': function () { window.omsApp.logger.log('left clicked'); },
        'exact': false
    }];
