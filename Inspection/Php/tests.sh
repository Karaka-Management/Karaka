#!/bin/bash

. config.sh

php ${TOOLS_PATH}/phpunit.phar -v --configuration ${TEST_PATH}/PHPUnit/phpunit_default.xml --log-junit ${INSPECTION_PATH}/Test/Php/junit_php.xml --testdox-html ${INSPECTION_PATH}/Test/Php/index.html --coverage-html ${INSPECTION_PATH}/Test/Php/coverage --coverage-clover ${INSPECTION_PATH}/Test/Php/coverage.xml > ${INSPECTION_PATH}/Test/Php/phpunit.log
#phpdbg -qrr phpunit.phar --configuration Tests/PHPUnit/phpunit_default.xml
#php .\documentor.phar -s C:\Users\coyle\Desktop\Orange-Management\phpOMS -d C:\Users\coyle\Desktop\Orange-Management\Build\log\docs -c C:\Users\coyle\Desktop\Orange-Management\Build\log\coverage.xml -u C:\Users\coyle\Desktop\Orange-Management\Build\log\test.xml -b http://127.0.0.1/Build/log/docs
#phpdbg -qrr phpunit.phar Tests/PHPUnit/Framework/Math/Matrix/MatrixTest.php --bootstrap Tests/PHPUnit/Bootstrap.php