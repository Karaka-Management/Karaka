/**
 * Perform DOM action.
 *
 * @param {{delay:int},{type:int}} data DOM action data
 *
 * @since 1.0.0
 */
const domAction = function (data)
{
    setTimeout(function ()
    {
        switch(data.type) {
        	case jsOMS.EnumDomActionType.SHOW: 
        		console.log('show');
        		break;
        	case jsOMS.EnumDomActionType.HIDE: 
        		console.log('hide');
        		break;
        }
    }, parseInt(data.delay));
};

/**
 * Show/Hide
 * identifier: #element or .elements or query
 * anim: someclass
 * delay: 0
 */