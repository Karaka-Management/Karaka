import { Logger } from '../../../../jsOMS/Log/Logger.js';

/** global: jsOMS */
export const VOICE_EVENTS = {
    'read': 'read_text',
    'help': function() { Logger.instance.debug('There is no help for you.'); },
};