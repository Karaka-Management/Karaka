jsOMS.ready(function ()
{
    "use strict";

    const video = document.getElementById('iVideoCanvas');
    const login = document.getElementById('iLoginButton');
    const loginText = document.getElementById('iLoginText');
    const countdown = document.getElementById('iCountdown');
    const clock = document.getElementById('iCountdownClock');

    login.addEventListener('click', function() {
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true, audio: false }).then(function(stream) {
                video.srcObject = stream;
                video.play();

                jsOMS.addClass(login, 'hidden');
                jsOMS.removeClass(video, 'hidden');
                jsOMS.removeClass(loginText, 'hidden');

                var timer = 10;
                clock.innerHTML = timer;
                jsOMS.removeClass(countdown, 'hidden');

                const cameraTimer = setInterval(function() {
                    timer -= 1;
                    clock.innerHTML = timer;

                    if (timer <= 0) {
                        jsOMS.addClass(loginText, 'hidden');
                        jsOMS.addClass(countdown, 'hidden');
                        jsOMS.addClass(video, 'hidden');
                        jsOMS.removeClass(login, 'hidden');

                        video.pause();
                        stream.getVideoTracks()[0].stop();;

                        clearInterval(cameraTimer);
                    }
                }, 1000);
            });
        }
    });
});
