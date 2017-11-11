/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const requestAction = function (action, callback, element)
{
    "use strict";
    
    const request = new jsOMS.Message.Request.Request(action.uri, action.method, action.request_type);
    
    request.setSuccess(function(xhr) {
        callback(JSON.parse(xhr.responseText));
    });

    if(typeof action.data !== 'undefined') {
        request.setData(action.data);
    }
   
    request.send();
};
