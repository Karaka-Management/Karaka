/** global: jsOMS */
const VOICE_EVENTS = {
    'read': 'read_text',
    'help': function() { jsOMS.Log.Logger.instance.debug('There is no help for you.'); },
};