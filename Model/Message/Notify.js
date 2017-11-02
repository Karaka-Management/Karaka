/**
 * Set message.
 *
 * @param {{title:string},{content:string},{level:int},{delay:int},{stay:int}} data Message data
 *
 * @since 1.0.0
 */
const notifyMessage = function (data)
{
    setTimeout(function ()
    {
        const notify  = document.createElement('div'),
            h       = document.createElement('h1'),
            inner   = document.createElement('div'),
            title   = document.createTextNode(data.title),
            content = document.createTextNode(data.msg);

        notify.id    = 'notify';
        notify.class = data.level;
        h.appendChild(title);
        inner.appendChild(content);
        notify.appendChild(h);
        notify.appendChild(inner);
        document.body.appendChild(notify);

        if (data.stay <= 0) {
            data.stay = 5000;
        }

        if (data.stay > 0) {
            setTimeout(function ()
            {
                notify.parentElement.removeChild(notify);
            }, data.stay);
        }
    }, parseInt(data.delay));
};
