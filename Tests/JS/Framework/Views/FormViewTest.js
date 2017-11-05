describe('FormViewTest', function ()
{
    "use strict";
    var testId = 'testForm';

    beforeEach(function ()
    {
        document.body.innerHTML += '
            <form id="' + testId + '" method="POST" action="{base}/{#testHiddenInputText}">
                <input id="testInputText" value="inputtext" name="testInputTextName">
                <input id="testInputRequired" value="" name="testInputRequiredName" required>
                <input id="testInputPattern" value="" name="testInputPatternName" pattern="\d+">
                <input type="hidden" id="testHiddenInputText" name="testHiddenInputTextName" value="hidden input text">
                <textarea id="testTextarea" name="testTextareaName" value="textarea text"></textarea>
                <input type="submit" id="defaultSubmit">
                <button type="submit" id="buttenSubmit">
            </form>

            <input form="' + testId + '" id="externalInputText" name="externalInputTextName" value="external text">
        ';
    });

    afterEach(function ()
    {
        let element = document.getElementById(testId);
        element.parentNode.removeChild(element);
    });

    describe('testDefault', function ()
    {
        it('Testing default functionality', function ()
        {
            let form = new jsOMS.Views.FormView(testId);
            expect(form.getId()).toBe(testId);
            expect(form.getElementId()).toBe(testId);
            expect(form.getElement()).toBe(testId);
            expect(form.getMethod()).toBe('POST');
            expect(form.getAction()).toBe('http://127.0.0.1/');
            expect(form.getSubmit()).toBe(null);
            expect(form.getSuccess()).toBe(null);
            expect(form.getFormElements()).toBe(null);
            expect(form.getData()).toBe(null);
            expect(form.isValid()).toBeTruthy();
        });
    });

    describe('testChanges', function ()
    {
        it('Testing modifications', function ()
        {
            let form = new FormView(testId);
            expect(form.getMethod()).toBe('POST');

            form.getElement().method = 'GET';

            expect(form.getMethod()).toBe('POST');
            form.bind();
            expect(form.getMethod()).toBe('GET');
        });
    });
});
