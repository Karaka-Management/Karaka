#!/bin/bash

# Paths
BASE_PATH="/var/www/html"
ROOT_PATH="/var/www/html/Orange-Management"
BUILD_PATH="/var/www/Build"

TOOLS_PATH="/var/www/html/Tools"
RELEASE_PATH="/var/www/html/Release"
INSPECTION_PATH="/var/www/html/Inspection"
TEST_PATH="/var/www/html/Orange-Management/Tests"

# Web
WEB_URL="http://orange-management.de"
MAIL_ADDR=""

# Authentications
DB_USER="root"
DB_PASSWORD="123456"

# Git variables
GITHUB_URL[0]="https://github.com/Orange-Management/Orange-Management.git"

GIT_BRANCH="develop"

DATE=$(date +%Y-%m-%d)
VERSION_HASH=${DATE}
