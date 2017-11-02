#!/bin/bash

. config.sh

php ${TOOLS_PATH}/phploc.phar ${ROOT_PATH}/phpOMS/ > ${INSPECTION_PATH}/Framework/phploc.log
php ${TOOLS_PATH}/phploc.phar ${ROOT_PATH}/Modules/ > ${INSPECTION_PATH}/Modules/phploc.log

php ${TOOLS_PATH}/phpmetrics.phar --report-html=${INSPECTION_PATH}/Framework/metrics/metrics.html ${ROOT_PATH}/phpOMS/ >> ${INSPECTION_PATH}/Framework/build.log
php ${TOOLS_PATH}/phpmetrics.phar --report-html=${INSPECTION_PATH}/Modules/metrics/metrics.html ${ROOT_PATH}/Modules/ >> ${INSPECTION_PATH}/Modules/build.log

php ${TOOLS_PATH}/pdepend.phar --summary-xml=${INSPECTION_PATH}/Framework/pdepend/pdepend.xml --jdepend-chart=${INSPECTION_PATH}/Framework/pdepend/chart.svg --overview-pyramid=${INSPECTION_PATH}/Framework/pdepend/pyramid.svg ${ROOT_PATH}/phpOMS
php ${TOOLS_PATH}/pdepend.phar --summary-xml=${INSPECTION_PATH}/Modules/pdepend/pdepend.xml --jdepend-chart=${INSPECTION_PATH}/Modules/pdepend/chart.svg --overview-pyramid=${INSPECTION_PATH}/Modules/pdepend/pyramid.svg ${ROOT_PATH}/Modules
