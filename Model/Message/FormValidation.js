/**
 * Set message.
 *
 * @param {{delay:int},{errors:string},{form:string}} data Message data
 *
 * @since 1.0.0
 */
const formValidationMessage = function (data) {
    const form = document.getElementById(data.form);

    if(!form) {
        return;
    }

    const eEles = document.getElementsByClassName('i-' + data.form);

    while (eEles.length > 0) {
        eEles[0].parentNode.removeChild(eEles[0]);
    }

    /**
     * @param {{msg:string}} error Error data
     */
    data.errors.forEach(function (error) {
        const eEle = document.getElementById(error.id);

        if(!eEle) {
            return;
        }

        const msgEle = document.createElement('i'),
            msg = document.createTextNode(error.msg);

        msgEle.id = 'i-' + error.id;
        msgEle.class = 'i-' + data.form;
        msgEle.appendChild(msg);
        eEle.parentNode.insertBefore(msgEle, eEle.nextSibling);
    });
};
