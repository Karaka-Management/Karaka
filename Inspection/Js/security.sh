#!/bin/bash

. config.sh

# JS code inspection
CODE[0]="onload"
CODE[1]="onclick"
CODE[2]="onchange"
CODE[3]="onselect"
CODE[4]="onsubmit"
CODE[5]="onfocus"
CODE[6]="onresize"
CODE[7]="onreset"
CODE[8]="onunload"
CODE[9]="onkeyup"
CODE[10]="onkeydown"
CODE[11]="onkeypress"
CODE[12]="onerror"
CODE[13]="ondragdrop"
CODE[14]="onabort"
CODE[15]="ondblclick"
CODE[16]="onmousedown"
CODE[17]="onmousemove"
CODE[18]="onmouseout"
CODE[19]="onmouseover"
CODE[20]="onmouseup"
CODE[21]="onmove"
CODE[22]="onblur"

for i in "${CODE[@]}"
do
    grep -rlni "$i" --include \*.js ${ROOT_PATH}/jsOMS >> ${INSPECTION_PATH}/Framework/critical_js.log
    grep -rlni "$i" --include \*.js ${ROOT_PATH}/Modules >> ${INSPECTION_PATH}/Modules/citical_js.log
    grep -rlni "$i" --include \*.js ${ROOT_PATH}/Web >> ${INSPECTION_PATH}/Web/citical_js.log
done

# JS strict type
grep -r -L "\"use strict\";" --include=*.js ${ROOT_PATH}/jsOMS > ${INSPECTION_PATH}/Framework/strict_missing_js.log
grep -r -L "\"use strict\";" --include=*.js ${ROOT_PATH}/Modules > ${INSPECTION_PATH}/Modules/strict_missing_js.log
grep -r -L "\"use strict\";" --include=*.js ${ROOT_PATH}/Web > ${INSPECTION_PATH}/Web/strict_missing_js.log
grep -r -L "\"use strict\";" --include=*.js ${ROOT_PATH}/Model > ${INSPECTION_PATH}/Model/strict_missing_js.log