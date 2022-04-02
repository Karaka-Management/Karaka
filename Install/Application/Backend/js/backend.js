import { AssetManager } from '../../../jsOMS/Asset/AssetManager.js';
import { Logger } from '../../../jsOMS/Log/Logger.js';
import { CacheManager } from '../../../jsOMS/DataStorage/CacheManager.js';
import { StorageManager } from '../../../jsOMS/DataStorage/StorageManager.js';
import { EventManager } from '../../../jsOMS/Event/EventManager.js';
import { ResponseManager } from '../../../jsOMS/Message/Response/ResponseManager.js';
import { AccountManager } from '../../../jsOMS/Account/AccountManager.js';
import { UIManager } from '../../../jsOMS/UI/UIManager.js';
import { InputManager } from '../../../jsOMS/UI/Input/InputManager.js';
import { ModuleManager } from '../../../jsOMS/Module/ModuleManager.js';
import { ReadManager } from '../../../jsOMS/UI/Input/Voice/ReadManager.js';
import { VoiceManager } from '../../../jsOMS/UI/Input/Voice/VoiceManager.js';
import { NotificationManager } from '../../../jsOMS/Message/Notification/NotificationManager.js';
import { HttpUri } from '../../../jsOMS/Uri/HttpUri.js';
import { UriFactory } from '../../../jsOMS/Uri/UriFactory.js';

import { ACTION_EVENTS } from './global/ActionEvents.js';
import { KEYBOARD_EVENTS } from './global/KeyboardEvents.js';
import { MOUSE_EVENTS } from './global/MouseEvents.js';
import { RESPONSE_EVENTS } from './global/ResponseEvents.js';
import { TOUCH_EVENTS } from './global/TouchEvents.js';
import { VOICE_EVENTS } from './global/VoiceEvents.js';

/**
 * Application entry point
 *
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @since     1.0.0
 */
export class Application
{
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    constructor ()
    {
        //jsOMS.Autoloader.initPreloaded();

        this.logger   = Logger.getInstance(true, false, false);
        window.logger = this.logger;

        this.cacheManager    = new CacheManager();
        this.storageManager  = new StorageManager();
        this.eventManager    = new EventManager();
        this.responseManager = new ResponseManager();
        this.assetManager    = new AssetManager();
        this.accountManager  = new AccountManager();
        this.uiManager       = new UIManager(this);
        this.inputManager    = new InputManager(this);
        this.moduleManager   = new ModuleManager(this);
        this.readManager     = new ReadManager();
        this.voiceManager    = new VoiceManager(this);
        this.notifyManager   = new NotificationManager();
        this.request         = new HttpUri(window.location.href);

        this.request.setRootPath(
            HttpUri.parseUrl(
                document.getElementsByTagName('base')[0].href
            ).path
        );

        this.setResponseMessages();

        this.setActions();
        this.setKeyboardActions();
        this.setMouseActions();
        this.setVoiceActions();

        UriFactory.setupUriBuilder(this.request);
        UriFactory.setQuery('/lang', window.location.href.substr(this.request.getBase().length).split('/')[0]);

        this.uiManager.bind();
        this.setupServiceWorker();
    };

    /**
     * Setup the service worker
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setupServiceWorker ()
    {
        /** global: navigator */
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/Web/Backend/ServiceWorker.js', {scope: this.request.getBase()}).catch(function (e)
            {
                Logger.instance.warning('ServiceWorker registration failed.');
            });
        }
    };

    /**
     * Setup the response manager
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setResponseMessages ()
    {
        /** global: RESPONSE_EVENTS */
        for(let key in RESPONSE_EVENTS) {
            if(RESPONSE_EVENTS.hasOwnProperty(key)) {
                this.responseManager.add(key, RESPONSE_EVENTS[key]);
            }
        }
    };

    /**
     * Setup the action manager
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setActions ()
    {
        /** global: ACTION_EVENTS */
        for(let key in ACTION_EVENTS) {
            if(ACTION_EVENTS.hasOwnProperty(key)) {
                this.uiManager.getActionManager().add(key, ACTION_EVENTS[key]);
            }
        }
    };

    /**
     * Setup the keyboard manager
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setKeyboardActions ()
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

    /**
     * Setup the mouse manager
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setMouseActions ()
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

    /**
     * Setup the voice manager
     *
     * @return {void}
     *
     * @sicne 1.0.0
     */
    setVoiceActions ()
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
};

/**
 * Create the application after loading the page
 */
jsOMS.ready(function ()
{
    "use strict";

    window.omsApp = new Application();
});
