/**
 * Set message.
 *
 * @param {Object} action Action data
 * @param {function} callback Callback
 * @param {Object} element Action element
 *
 * @since 1.0.0
 */
const tableAppend = function (action, callback, element)
{
    "use strict";

    const table = document.getElementById(action.id),
        tbody = table !== null && typeof table !== 'undefined' ? table.getElementsByTagName('tbody')[0] : null,
        headers = table !== null && typeof table !== 'undefined' ? table.getElementsByTagName('thead')[0].getElementsByTagName('th') : null,
        dataLength = action.data.length,
        headerLength = headers !== null && typeof headers !== 'undefined' ? headers.length : 0;

    let row, cell, text, rawText;

    for(let i = 0; i < dataLength; i++) {
        if(tbody === null) {
            break;
        }

        row = tbody.insertRow(tbody.rows.length);

        for(let j = 0; j < headerLength; j++) {
            if(row === null) {
                break;
            }

            cell = row.insertCell(j);
            rawText = action.data[i][headers[j].getAttribute('data-name')];

            if(typeof rawText === 'undefined') {
                rawText = '';
            }

            cell.appendChild(document.createTextNode(rawText));
        }
    }
    
    callback();
};
