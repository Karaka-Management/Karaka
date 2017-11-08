/** global: jsOMS */
const ACTION_EVENTS = {
    'redirect': redirectMessage,
    'dom': domAction,
    'dom.popup': popupButtonAction,
    'dom.remove': removeButtonAction,
    'dom.show': showAction,
    'dom.hide': hideAction,
    'dom.setvalue': domSetValue,
    'dom.removevalue': domRemoveValue,
    'dom.getvalue': domGetValue,
    'dom.focus': focusAction,
    'dom.table.append': tableAppend,
    'dom.table.clear': tableClear,
    'dom.datalist.clear': datalistClear,
    'dom.datalist.append': datalistAppend,
    'message.request': requestAction,
    'utils.timer': timerAction,
    'validate.keypress': validateKeypress
};