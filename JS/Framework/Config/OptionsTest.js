describe('OptionsTest', function ()
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
            let option = new jsOMS.Config.Options();
            expect(option.get('invalid')).toBe(null);
            expect(option.remove('invalid')).toBeFalsy();
        });
    });

    describe('testSetGet', function ()
    {
        it('Testing set/get functionality', function ()
        {
            let option = new jsOMS.Config.Options();

            expect(option.set('a', 2)).toBeTruthy();
            expect(option.get('a')).toBe(2);
            expect(option.set('a', 3)).toBeFalsy();
            expect(option.get('a')).toBe(2);
            expect(option.set('a', 3, true)).toBeTruthy();
            expect(option.get('a')).toBe(3);

            expect(option.remove('a')).toBeTruthy();
            expect(option.get('a')).toBe(null);
            expect(option.remove('a')).toBeFalsy();
        });
    });
});
