/**
 * Account Manager.
 *
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @since      1.0.0
 */
(function (jsOMS)
{
    "use strict";
    
    jsOMS.Autoloader.defineNamespace('jsOMS.Account');
    
    /**
     * @constructor
     *
     * @since 1.0.0
     */
    jsOMS.Account.AccountManager = function ()
    {
        this.accounts = [];
    };

    /**
     * Add account.
     *
     * @param {Object} account Account
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Account.AccountManager.prototype.add = function (account)
    {
        this.accounts[account.getId()] = account;
    };

    /**
     * Remove account.
     *
     * @param {int} id Account id
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Account.AccountManager.prototype.remove = function (id)
    {
        if (typeof this.accounts[id] !== 'undefined') {
            delete this.accounts[id];

            return true;
        }

        return false;
    };

    /**
     * Get account by id.
     *
     * @param {int} id Account id
     *
     * @return {Object}
     *
     * @method
     *
     * @since 1.0.0
     */
    jsOMS.Account.AccountManager.prototype.get = function (id)
    {
        if (this.accounts[id]) {
            return this.accounts[id];
        }

        return undefined;
    };
}(window.jsOMS = window.jsOMS || {}));
