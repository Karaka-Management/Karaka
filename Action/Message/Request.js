/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
 *
 * @since 1.0.0
 */
const requestAction = function (action, callback, data)
{
    "use strict";
    
    const request = new jsOMS.Message.Request.Request(action.uri, action.method, action.request_type);
    console.log(request);
    request.setSuccess(function(xhr) {
        console.log(xhr.responseText);
        callback(JSON.parse(xhr.responseText));
    });

    if(typeof action.data !== 'undefined') {
        request.setData(action.data);
    }
   
    request.send();
};
