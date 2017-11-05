/**
 * Form manager class.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";

    /** @namespace jsOMS.UI */
    jsOMS.Autoloader.defineNamespace('jsOMS.UI.Input.Voice');

    // todo: remove once obsolete
    /** global: webkitSpeechRecognition */
    /** global: SpeechRecognition */
    var SpeechRecognition = typeof SpeechRecognition !== 'undefined' ? SpeechRecognition : typeof webkitSpeechRecognition !== 'undefined' ? webkitSpeechRecognition : null;
    
    /** global: webkitSpeechGrammarList */
    /** global: SpeechGrammarList */
    var SpeechGrammarList = typeof SpeechGrammarList !== 'undefined' ? SpeechGrammarList : typeof webkitSpeechGrammarList !== 'undefined' ? webkitSpeechGrammarList : null;
    
    /** global: webkitSpeechRecognitionEvent */
    /** global: SpeechRecognitionEvent */
    var SpeechRecognitionEvent = typeof SpeechRecognitionEvent !== 'undefined' ? SpeechRecognitionEvent : typeof webkitSpeechRecognitionEvent !== 'undefined' ? webkitSpeechRecognitionEvent : null;

    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager = function (lang)
    {
        this.pitch = 1;
        this.rate = 1;
        this.lang = typeof lang === 'undefined' ? 'en-US' : lang;    
        this.voices = [];
        this.voice = null;

        if(SpeechRecognition !== null) {
            this.voices = window.speechSynthesis.getVoices();
            this.voice = this.voices[0];
        }
    };

    /**
     * Read text.
     * 
     * @param {string} text Text to read
     *
     * @return {void}
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager.prototype.read = function(text)
    {
        /** global: SpeechSynthesisUtterance */
        let utter = new SpeechSynthesisUtterance(text);
        utter.lang = this.lang;
        utter.voice = this.voice;
        utter.pitch = this.pitch;
        utter.rate = this.rate;
        window.speechSynthesis.speak(utter);
    };

    /**
     * Set Language.
     * 
     * @param {string} lang Language id (e.g. en-US)
     *
     * @return {void}
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager.prototype.setLanguage = function(lang)
    {
        this.lang = lang;
    };

    /**
     * Set pitch.
     * 
     * @param {int} pitch Pitch
     *
     * @return {void}
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager.prototype.setPitch = function(pitch)
    {
        this.pitch = pitch;
    };

    /**
     * Set rate.
     * 
     * @param {int} rate Rate
     *
     * @return {void}
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager.prototype.setRate = function(rate)
    {
        this.rate = rate;
    };

    /**
     * Get supported voices.
     * 
     * @return {Array}
     *
     * @since  1.0.0
     */
    jsOMS.UI.Input.Voice.ReadManager.prototype.getVoices = function()
    {
        return this.voices;
    };
}(window.jsOMS = window.jsOMS || {}));