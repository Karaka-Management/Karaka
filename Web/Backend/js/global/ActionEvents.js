/** global: jsOMS */
const ACTION_EVENTS = {
    'redirect': redirectMessage, /** global: redirectMessage */
    'dom': domAction, /** global: domAction */
    'dom.popup': popupButtonAction, /** global: popupButtonAction */
    'dom.remove': removeButtonAction, /** global: removeButtonAction */
    'dom.show': showAction, /** global: showAction */
    'dom.hide': hideAction, /** global: hideAction */
    'dom.setvalue': domSetValue, /** global: domSetValue */
    'dom.removevalue': domRemoveValue, /** global: domRemoveValue */
    'dom.getvalue': domGetValue, /** global: domGetValue */
    'dom.focus': focusAction, /** global: focusAction */
    'dom.table.append': tableAppend, /** global: tableAppend */
    'dom.table.clear': tableClear, /** global: tableClear */
    'dom.datalist.clear': datalistClear, /** global: datalistClear */
    'dom.datalist.append': datalistAppend, /** global: datalistAppend */
    'message.request': requestAction, /** global: requestAction */
    'utils.timer': timerAction, /** global: timerAction */
    'validate.keypress': validateKeypress /** global: validateKeypress */
};