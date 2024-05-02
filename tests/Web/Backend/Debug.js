// This is a debug script to find issues in html
// 1. Open the website in your browser
// 2. Log into the application
// 3. Copy the entire content of this file
// 4. Paste it into the console in your browser
// 5. Wait until the browser is done loading all the pages (see limit pageLimit)
// 6. At the end of the console output you should find a table with stats regarding potentially problematic html

const visited        = [];
const findings       = {};
const cssSelectors   = {};
const cssFiles       = ['http://127.0.0.1/cssOMS/styles.css'];
const cssFilesLength = cssFiles.length;
const domain         = window.location.hostname;
const pageLimit      = 100;

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

try {
    const cssRequest              = new XMLHttpRequest();
    cssRequest.onreadystatechange = function ()
    {
        if (cssRequest.readyState === 4 && cssRequest.status === 200) {
            const cssText      = this.responseText;
            const result       = cssText.match(/[a-zA-Z0-9\ :>~\.\"'#,\[\]=\-\(\)\*]+{/g);
            const resultLength = result.length;

            for (let i = 1; i < resultLength; ++i) {
                const sel = result[i].substring(0, result[i].length - 1).trim();
                if (!Object.prototype.hasOwnProperty.call(cssSelectors, sel)) {
                    cssSelectors[sel] = 0;
                }
            }
        }
    };

    for (let i = 0; i < cssFilesLength; ++i) {
        cssRequest.open('GET', cssFiles[i], true);
        cssRequest.send();
    }

    async function validatePage (url)
    {
        if (visited.includes(url) || visited.length > pageLimit - 1 || url.includes('mailto:')) {
            return;
        }

        // mark url as visited
        visited.push(url);
        findings[url] = {};

        // web request
        const response = await fetch(url);
        const html = await response.text();

        // replace content
        document.open();
        document.write(html);
        document.close();

        // analyze img alt attribute
        const imgAlt          = document.querySelectorAll('img:not([alt]), img[alt=""], img[alt=" "]');
        findings[url].img_alt = imgAlt.length;

        // analyze img src
        const imgSrc          = document.querySelectorAll('img:not([src]), img[src=""], img[src=" "]');
        findings[url].img_src = imgSrc.length;

        // analyze empty link
        const aHref              = document.querySelectorAll('a[href=""], a[href=" "], a[href="#"]');
        findings[url].href_empty = aHref.length;

        /* eslint-disable max-len */
        // analyze inline on* function
        const onFunction    = document.querySelectorAll('[onafterprint], [onbeforeprint], [onbeforeunload], [onerror], [onhaschange], [onload], [onmessage], [onoffline], [ononline], [onpagehide], [onpageshow], [onpopstate], [onredo], [onresize], [onstorage], [onundo], [onunload], [onblur], [onchage], [oncontextmenu], [onfocus], [onformchange], [onforminput], [oninput], [oninvalid], [onreset], [onselect], [onsubmit], [onkeydown], [onkeypress], [onkeyup], [onclick], [ondblclick], [ondrag], [ondragend], [ondragenter], [ondragleave], [ondragover], [ondragstart], [ondrop], [onmousedown], [onmousemove], [onmouseout], [onmouseover], [onmouseup], [onmousewheel], [onscroll], [onabort], [oncanplay], [oncanplaythrough], [ondurationchange], [onemptied], [onended], [onerror], [onloadeddata], [onloadedmetadata], [onloadstart], [onpause], [onplay], [onplaying], [onprogress], [onratechange], [onreadystatechange], [onseeked], [onseeking], [onstalled], [onsuspend], [ontimeupdate], [onvolumechange], [onwaiting]');
        findings[url].js_on = onFunction.length;

        // analyze missing form element attributes
        const formElements          = document.querySelectorAll('input:not([id]), input[type=""], select:not([id]), textarea:not([id]), label:not([for]), label[for=""], label[for=" "], input:not([name]), select:not([name]), textarea:not([name]), form:not([id]), form:not([action]), form[action=""], form[action=" "], form[action="#"]');
        findings[url].form_elements = formElements.length;

        // analyze invalid container-children relationship (e.g. empty containers, invalid children)
        const invalidContainerChildren           = document.querySelectorAll(':not(tr) > td, :not(tr) > th, colgroup *:not(col), :not(colgroup) > col, tr > :not(td):not(th), optgroup > :not(option), :not(select) > option, :not(fieldset) > legend, select > :not(option):not(optgroup), :not(select):not(optgroup) > option, table > *:not(thead):not(tfoot):not(tbody):not(tr):not(colgroup):not(caption)');
        findings[url].invalid_container_children = invalidContainerChildren.length;
        /* eslint-enable max-len */

        // has inline styles
        const hasInlineStyles       = document.querySelectorAll('*[style]');
        findings[url].inline_styles = hasInlineStyles.length;

        // analyze css usage
        let cssFound;
        for (const i in cssSelectors) {
            try {
                cssFound        = document.querySelectorAll(i.replace(/:hover|:active/gi, ''));
                cssSelectors[i] = cssFound === null ? 0 : cssFound.length;
            } catch (e) {}
        }

        // check other pages
        const links      = document.querySelectorAll('a');
        const linkLength = links.length;

        for (let i = 0; i < linkLength; ++i) {
            if (visited.includes(links[i].href)
                || (!links[i].href.startsWith('/')
                    && links[i].href.startsWith('http')
                    && !links[i].href.includes(domain)
                )
            ) {
                continue;
            }

            await validatePage(links[i].href);
        }
    };

    (async () => {
        await validatePage(location.href);

        console.table(findings);
        console.table(cssSelectors);
    })();
} catch(e) {
    console.log(e.message);
}
