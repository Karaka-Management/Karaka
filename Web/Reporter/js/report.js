jsOMS.ready(function () {


    var route = new jsOMS.Route();
    var request = new jsOMS.Message.Request.Request();
    var auth = new jsOMS.Auth();

    route.add('/backend.php', loginButton);

    var loginButton = function () {
        /* LOGIN PAGE */
        var loginbutton = null;

        if ((loginbutton = document.getElementById('login-button'))) {
            loginbutton.addEventListener('click', function () {
                auth.login();
            });
        }
    }
});