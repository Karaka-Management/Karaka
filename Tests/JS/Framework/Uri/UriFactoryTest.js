describe('UriFactoryTest', function ()
{
    "use strict";

    /** global: jsOMS */
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
            expect(jsOMS.Uri.UriFactory.getQuery('Invalid')).toBe(null);
        });
    });

    describe('testSetGet', function ()
    {
        it('Testing query setting', function ()
        {
            expect(jsOMS.Uri.UriFactory.setQuery('Valid', 'query1')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.getQuery('Valid')).toBe('query1');

            expect(jsOMS.Uri.UriFactory.setQuery('Valid', 'query2', true)).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.getQuery('Valid')).toBe('query2');

            expect(jsOMS.Uri.UriFactory.setQuery('Valid', 'query3', false)).toBeFalsy();
            expect(jsOMS.Uri.UriFactory.getQuery('Valid')).toBe('query2');

            expect(jsOMS.Uri.UriFactory.setQuery('/valid2', 'query4')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.getQuery('/valid2')).toBe('query4');
        });
    });

    describe('testClearing', function ()
    {
        it('Testing query clearing', function ()
        {
            expect(jsOMS.Uri.UriFactory.clear('Valid')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.clear('Valid')).toBeFalsy();
            expect(jsOMS.Uri.UriFactory.getQuery('Valid')).toBe(null);
            expect(jsOMS.Uri.UriFactory.getQuery('/valid2')).toBe('query4');

            expect(jsOMS.Uri.UriFactory.clearAll()).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.getQuery('/valid2')).toBe(null);

            expect(jsOMS.Uri.UriFactory.setQuery('/abc', 'query1')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.setQuery('/valid2', 'query2')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.setQuery('/valid3', 'query3')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.clearLike('^d+$')).toBeFalsy();
            expect(jsOMS.Uri.UriFactory.clearLike('\/[a-z]*\d')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.getQuery('/valid2')).toBe(null);
            expect(jsOMS.Uri.UriFactory.getQuery('/valid3')).toBe(null);
            expect(jsOMS.Uri.UriFactory.getQuery('/abc')).toBe('query1');
        });
    });

    describe('testBuilder', function ()
    {
        it('Testing global queries', function ()
        {
            let uri = 'www.test-uri.com?id={@ID}&test={.mTest}&two={/path}&hash={#hash}&none=#none&found={/not}&v={/valid2}',
                vars = {
                '@ID'   : 1,
                '.mTest': 'someString',
                '/path' : 'PATH',
                '#hash' : 'test',
            },
            expected = 'www.test-uri.com?id=1&test=someString&two=PATH&hash=test&none=#none&found=ERROR PATH&v=query4';;

            expect(jsOMS.Uri.UriFactory.setQuery('/valid2', 'query4')).toBeTruthy();
            expect(jsOMS.Uri.UriFactory.build(uri, vars)).toBe(expected);
        });
    });
});