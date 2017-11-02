/**
 * Set message.
 *
 * @param {{delay:int}} data Message data
 *
 * @since 1.0.0
 */
const reloadMessage = function (data) {
    setTimeout(function () {
        document.location.reload(true);
    }, parseInt(data.delay));
};
