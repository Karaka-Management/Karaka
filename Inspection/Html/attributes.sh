#!/bin/bash

. config.sh

# Find empty attributes
grep -rln "=\"\"" --include \*.tpl.php ${ROOT_PATH} > ${INSPECTION_PATH}/Modules/html/attributes_empty.log

# Find invalid attributes
find ${ROOT_PATH} -name "*tpl.php" | xargs -0 grep '(id=")([\ ]*)(")' > ${INSPECTION_PATH}/Modules/html/attributes_invalid.log
find ${ROOT_PATH} -name "*tpl.php" | xargs -0 grep '(min=")([a-zA-Z]*)(")' >> ${INSPECTION_PATH}/Modules/html/attributes_invalid.log
find ${ROOT_PATH} -name "*tpl.php" | xargs -0 grep '(max=")([a-zA-Z]*)(")' >> ${INSPECTION_PATH}/Modules/html/attributes_invalid.log
find ${ROOT_PATH} -name "*tpl.php" | xargs -0 grep '(=")([#$%^&*\(\)\\/]*)(")' >> ${INSPECTION_PATH}/Modules/html/attributes_invalid.log
find ${ROOT_PATH} -name "*tpl.php" | xargs -0 grep '(<img(?!.*?alt=(["]).*?\2)[^>]*?)(/?>)' >> ${INSPECTION_PATH}/Modules/html/attributes_invalid.log
