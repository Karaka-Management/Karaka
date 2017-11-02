#!/bin/bash

DIRECTORY_TO_OBSERVE="cssOMS jsOMS"
function watcher {
  inotifywait -r -e modify,move,create,delete \
    --exclude ".*(\.css|\.php|\.json|\.md|\.sh|\.txt|\.log|\.min\.js)" \
     ${DIRECTORY_TO_OBSERVE}
}

BUILD_SCRIPT=build_frontend.sh
function build {
  bash ${BUILD_SCRIPT}
}

build
while watcher; do
  build
done
