/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} action Message data
 * @param {function} callback Callback
 *
 * @since 1.0.0
 */
const timerActionDelay = {};
const timerAction = function (action, callback)
{
    "use strict";
    
   if(timerActionDelay[action.id]) {
       clearTimeout(timerActionDelay[action.id]);
       delete timerActionDelay[action.id]
   }

   timerActionDelay[action.id] = setTimeout(function() { 
       delete timerActionDelay[action.id]; 
       callback();
    }, action.delay);
};
