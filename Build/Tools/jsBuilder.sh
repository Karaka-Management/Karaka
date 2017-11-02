#!/bin/bash

echo "" > ${OUT}
for i in "${SRC[@]}"
do
    cat $i >> ${OUT}
    echo "" >> ${OUT}
done

java -jar ${TOOLS_PATH}/closure-compiler* --compilation_level WHITESPACE_ONLY --js ${OUT} --js_output_file ${OUT}.min
rm ${OUT}
mv ${OUT}.min ${OUT}

# Remove spaces at end of line
sed -i -e 's/[[:blank:]]*$//g' ${OUT}
# Make single line
sed -i -e ':a;N;$!ba;s/\n/ /g' ${OUT}
# Remove multiple spaces
sed -i -e 's/  */ /g' ${OUT}
# Remove double js initialization
sed -i -e 's/(function *(jsOMS) *{ *"use strict";//g' ${OUT}
sed -i -e 's/} *(window.jsOMS *= *window.jsOMS *|| *{}));//g' ${OUT}

echo "(function(jsOMS){\"use strict\";$(cat ${OUT})}(window.jsOMS = window.jsOMS || {}));" > ${OUT}