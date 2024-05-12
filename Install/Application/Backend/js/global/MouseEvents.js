import { EventType } from '../../../../../jsOMS/UI/Input/Mouse/EventType.js';
import { ClickType } from '../../../../../jsOMS/UI/Input/Mouse/ClickType.js';

/** global: jsOMS */
export const MOUSE_EVENTS = [
    {
        'element': '#nav-side',
        'type': EventType.CONTEXT,
        'button': ClickType.RIGHT,
        'callback': function () { window.omsApp.logger.log('right clicked'); },
        'exact': true
    }, {
        'element': '#nav-side',
        'type': EventType.LONGPRESS,
        'button': ClickType.LEFT,
        'callback': function () { window.omsApp.logger.log('left clicked'); },
        'exact': false
    }, {
        'element': '[tabindex="0"][data-preview]',
        'type': EventType.CLICK,
        'button': ClickType.LEFT,
        'callback': async function () {
            const previewCheckbox = document.getElementById('hover-preview-checkbox');
            const hoveredElement = document.activeElement;

            if (hoveredElement === null) {
                return;
            }

            const preview = document.getElementById('hover-preview');

            const hoveredElementRec = hoveredElement.getBoundingClientRect();

            const link = hoveredElement.getAttribute('data-preview');
            if (!link) {
                return;
            }

            try {
                const response = await fetch(link, { mode: 'cors' });
                const html = await response.text();
                preview.innerHTML = html;

                const previewElementRec = preview.getBoundingClientRect();

                // Check if boxes (link/preview) overlap
                if (((previewElementRec.left < hoveredElementRec.left && previewElementRec.right > hoveredElementRec.left)
                        || (previewElementRec.left > hoveredElementRec.left && previewElementRec.left < hoveredElementRec.right))
                    && ((previewElementRec.top < hoveredElementRec.top && previewElementRec.bottom > hoveredElementRec.top)
                        || (previewElementRec.top > hoveredElementRec.top && previewElementRec.top < hoveredElementRec.bottom))
                ) {
                    /*
                    const newX = previewElementRec.right <= hoveredElementRec.left
                        ? previewElementRec.right
                        : hoveredElementRec.left - (previewElementRec.right - previewElementRec.left);
                    */

                    let newY = previewElementRec.top < hoveredElementRec.top
                        ? hoveredElementRec.top - previewElementRec.height - 20
                        : hoveredElementRec.bottom + 20;

                    if (newY < 0) {
                        newY = hoveredElementRec.bottom + 20;
                    } else if (newY + previewElementRec.height > window.innerHeight) {
                        newY = hoveredElementRec.top - previewElementRec.height - 20;
                    }

                    //preview.style.left = parseInt(newX) + 'px';
                    preview.style.top = parseInt(newY) + 'px';
                }

                previewCheckbox.checked = true;
                setTimeout(() => {
                    previewCheckbox.checked = false;
                }, '3000');
            } catch (error) {
                console.error('Error fetching content:', error.message);
            }
        },
        'exact': false
    }];
