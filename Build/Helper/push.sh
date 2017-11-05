#!/bin/bash

git push
git subtree push --prefix Web Web develop
git subtree push --prefix Socket Socket develop
git subtree push --prefix Console Console develop
git subtree push --prefix phpOMS phpOMS develop
git subtree push --prefix jsOMS jsOMS develop
git subtree push --prefix Tests Tests develop
git subtree push --prefix Model Model develop
git subtree push --prefix Modules Modules develop
git subtree push --prefix Build Build develop
git subtree push --prefix Developer-Guide Developer-Guide develop
git subtree push --prefix Documentation Documentation develop
git subtree push --prefix cssOMS cssOMS develop