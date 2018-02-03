(function (jsOMS)
{
    "use strict";

    jsOMS.Application = function ()
    {
        jsOMS.Autoloader.initPreloaded();

        this.logger   = jsOMS.Log.Logger.getInstance();
        window.logger = this.logger;

        this.cacheManager    = new jsOMS.DataStorage.CacheManager();
        this.cookieJar       = new jsOMS.DataStorage.CookieJar();
        this.storageManager  = new jsOMS.DataStorage.StorageManager();
        this.eventManager    = new jsOMS.Event.EventManager();
        this.responseManager = new jsOMS.Message.Response.ResponseManager();
        this.dispatcher      = new jsOMS.Dispatcher.Dispatcher();
        this.assetManager    = new jsOMS.Asset.AssetManager();
        this.acountManager   = new jsOMS.Account.AccountManager();
        this.uiManager       = new jsOMS.UI.UIManager(this);
        this.inputManager    = new jsOMS.UI.Input.InputManager(this);
        this.moduleManager   = new jsOMS.Module.ModuleManager(this);
        this.readManager     = new jsOMS.UI.Input.Voice.ReadManager();
        this.voiceManager    = new jsOMS.UI.Input.Voice.VoiceManager(this);
        this.notifyManager   = new jsOMS.Message.Notification.NotificationManager();
        this.request         = new jsOMS.Uri.Http(window.location.href);

        this.request.setRootPath(
            jsOMS.Uri.Http.parseUrl(
                document.getElementsByTagName('base')[0].href
            ).path
        );

        this.setResponseMessages();

        this.setActions();
        this.setKeyboardActions();
        this.setMouseActions();
        this.setVoiceActions();

        jsOMS.Uri.UriFactory.setupUriBuilder(this.request);
        jsOMS.Uri.UriFactory.setQuery('/lang', window.location.href.substr(this.request.getBase().length).split('/')[0]);

        this.uiManager.bind();
        this.setupServiceWorker();
    };

    jsOMS.Application.prototype.setupServiceWorker = function ()
    {
        /** global: navigator */
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/Web/Backend/ServiceWorker.js', {scope: this.request.getBase()}).catch(function (e)
            {
                jsOMS.Log.Logger.instance.warning('ServiceWorker registration failed.');
            });
        }
    };

    jsOMS.Application.prototype.setResponseMessages = function ()
    {
        /** global: RESPONSE_EVENTS */
        for(let key in RESPONSE_EVENTS) {
            if(RESPONSE_EVENTS.hasOwnProperty(key)) {
                this.responseManager.add(key, RESPONSE_EVENTS[key]);
            }
        }
    };

    jsOMS.Application.prototype.setActions = function ()
    {
        /** global: ACTION_EVENTS */
        for(let key in ACTION_EVENTS) {
            if(ACTION_EVENTS.hasOwnProperty(key)) {
                this.uiManager.getActionManager().add(key, ACTION_EVENTS[key]);
            }
        }
    };

    jsOMS.Application.prototype.setKeyboardActions = function ()
    {
        /** global: KEYBOARD_EVENTS */
        let length = KEYBOARD_EVENTS.length;

        for(let i = 0; i < length; i++) {
            this.inputManager.getKeyboardManager().add(
                KEYBOARD_EVENTS[i]['element'], 
                KEYBOARD_EVENTS[i]['keys'], 
                KEYBOARD_EVENTS[i]['callback']
            );
        }
    };

    jsOMS.Application.prototype.setMouseActions = function ()
    {
        /** global: MOUSE_EVENTS */
        let length = MOUSE_EVENTS.length;
        
        for(let i = 0; i < length; i++) {
            this.inputManager.getMouseManager().add(
                MOUSE_EVENTS[i]['element'], 
                MOUSE_EVENTS[i]['type'], 
                MOUSE_EVENTS[i]['button'], 
                MOUSE_EVENTS[i]['callback'],
                MOUSE_EVENTS[i]['exact']
            );
        }
    };

    jsOMS.Application.prototype.setVoiceActions = function ()
    {
        /** global: VOICE_EVENTS */
        for(let key in VOICE_EVENTS) {
            if(VOICE_EVENTS.hasOwnProperty(key)) {
                this.voiceManager.add(key, VOICE_EVENTS[key]);
            }
        }

        this.voiceManager.setup();
        this.voiceManager.start();
    };
}(window.jsOMS = window.jsOMS || {}));

jsOMS.ready(function ()
{
    "use strict";

    /** global: jsOMS */
    window.omsApp = new jsOMS.Application();
});
