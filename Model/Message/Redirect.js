/**
 * Set message.
 *
 * @param {{delay:int},{url:string}} data Message data
 *
 * @since 1.0.0
 */
const redirectMessage = function (data)
{
    setTimeout(function ()
    {
        /** global: jsOMS */
        window.location = jsOMS.Uri.UriFactory.build(data.uri);
    }, parseInt(data.delay));
};
