(function (jsOMS) {
    "use strict";
    
    jsOMS.EnumDomActionType = Object.freeze({
        CREATE_BEFORE: 0,
	    CREATE_AFTER: 1,
	    DELETE: 2,
	    REPLACE: 3,
	    MODIFY: 4,
	    SHOW: 5,
	    HIDE: 6,
	    ACTIVATE: 7,
	    DEACTIVATE: 8
    });
}(window.jsOMS = window.jsOMS || {}));
