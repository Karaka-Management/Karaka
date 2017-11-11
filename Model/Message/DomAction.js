/**
 * Perform DOM action.
 *
 * @param {{delay:int},{type:int}} data DOM action data
 *
 * @since 1.0.0
 */
const domAction = function (data)
{
	/** global: jsOMS */
    setTimeout(function ()
    {
        switch(data.type) {
        	case jsOMS.EnumDomActionType.SHOW: 
        		break;
        	case jsOMS.EnumDomActionType.HIDE: 
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