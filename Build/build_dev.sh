#!/bin/bash

# Include config
. config.sh

# Creating release path
rm -r -f ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
mkdir -p ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev

# Copying source files
cp -R ${ROOT_PATH}/Admin/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/External/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/phpOMS/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/Modules/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/Model/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/cssOMS/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/Web/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/Socket/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/Console/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev
cp -R ${ROOT_PATH}/jsOMS/ ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev

# Removing none dev files
find ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev -name "*.css" -type f -delete
find ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev -name "*.min.js" -type f -delete
find ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev -name "private.php" -type f -delete
find ${ROOT_PATH}/${RELEASE_PATH}/${VERSION_HASH}/Dev -name "private.sh" -type f -delete

# Documentation