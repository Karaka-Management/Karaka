#!/bin/bash

. config.sh

# Previous cleanup
rm -r -f ${ROOT_PATH}
mkdir -p ${ROOT_PATH}

rm -r -f ${INSPECTION_PATH}
mkdir -p ${INSPECTION_PATH}

# Handling git
c=0;
for i in "${GITHUB_URL[@]}"
do
    if [ "$c" -eq 0 ]
    then
        cd ${BASE_PATH}
    fi

    if [ "$c" -eq 1 ]
    then
        cd ${ROOT_PATH}
    fi

    git clone -b ${GIT_BRANCH} $i
    c=$((c+1))
done

# Creating directories
mkdir -p ${INSPECTION_PATH}/logs
mkdir -p ${INSPECTION_PATH}/Framework/logs
mkdir -p ${INSPECTION_PATH}/Framework/metrics
mkdir -p ${INSPECTION_PATH}/Framework/pdepend
mkdir -p ${INSPECTION_PATH}/Framework/phpcs
mkdir -p ${INSPECTION_PATH}/Framework/phpcpd
mkdir -p ${INSPECTION_PATH}/Framework/linting
mkdir -p ${INSPECTION_PATH}/Framework/html

mkdir -p ${INSPECTION_PATH}/Modules/logs
mkdir -p ${INSPECTION_PATH}/Modules/metrics
mkdir -p ${INSPECTION_PATH}/Modules/pdepend
mkdir -p ${INSPECTION_PATH}/Modules/phpcs
mkdir -p ${INSPECTION_PATH}/Modules/phpcpd
mkdir -p ${INSPECTION_PATH}/Modules/linting
mkdir -p ${INSPECTION_PATH}/Modules/html

mkdir -p ${INSPECTION_PATH}/Test/Php
mkdir -p ${INSPECTION_PATH}/Test/Js

# Permission handling
chmod -R 777 ${ROOT_PATH}

cd ${ROOT_PATH}
touch private.php

if [ ! -d "$TOOLS_PATH" ]; then
    mkdir -p ${TOOLS_PATH}

    cd ${TOOLS_PATH}

    # Downloading tools
    wget -nc https://getcomposer.org/composer.phar
    wget -nc https://phar.phpunit.de/phploc.phar
    wget -nc https://phar.phpunit.de/phpunit.phar
    wget -nc https://github.com/Halleck45/PhpMetrics/raw/master/build/phpmetrics.phar
    wget -nc http://phpdoc.org/phpDocumentor.phar
    wget -nc http://static.pdepend.org/php/latest/pdepend.phar
    wget -nc https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
    wget -nc http://static.phpmd.org/php/latest/phpmd.phar
    wget -nc https://phar.phpunit.de/phpcpd.phar
    wget -nc http://dl.google.com/closure-compiler/compiler-latest.tar.gz
    tar -zxvf compiler-latest.tar.gz

    cp ${BUILD_PATH}/Configs/composer.json ${TOOLS_PATH}/composer.json

    php composer.phar install
fi

ln -s ${TOOLS_PATH}/vendor ${ROOT_PATH}/vendor

# Installing tools
[[ $(jsonlint -h) != *"Usage: jsonlint"* ]] && npm install jsonlint -g
