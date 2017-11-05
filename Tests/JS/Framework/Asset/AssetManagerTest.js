describe('AssetManagerTest', function ()
{
    "use strict";

    beforeEach(function ()
    {
    });

    afterEach(function ()
    {
    });

    describe('testDefault', function ()
    {
        it('Testing default functionality', function ()
        {
            let asset = new jsOMS.Asset.AssetManager();
            expect(asset.get('invalid')).toBe(null);
            expect(asset.remove('invalid')).toBeFalsy();
        });
    });

    describe('testAssetInteraction', function ()
    {
        it('Testing asset interaction functionality', function ()
        {
            let asset = new jsOMS.Asset.AssetManager();
            expect(asset.get('../../../jsOMS/Utils/oLib.js')).not.toBe(null);
            expect(asset.remove('../../../jsOMS/Utils/oLib.js')).toBeTruthy();
            expect(asset.load('../../../jsOMS/Utils/oLib.js', 'js')).not.toBeFalsy();
        });
    });
});
