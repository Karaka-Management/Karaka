#!/bin/bash

# Include config
. config.sh

# Setting up database for demo and testing
mysql -e 'drop database if exists oms;' -u ${DB_USER} -p${DB_PASSWORD}
mysql -e 'create database oms;' -u ${DB_USER} -p${DB_PASSWORD}
#echo "USE mysql;\nUPDATE user SET password=PASSWORD('123456') WHERE user='root';\nFLUSH PRIVILEGES;\n" | mysql -u root

# Build js
. Js/build.sh

# Executing unit tests
. Inspection/Php/tests.sh

# Stats & metrics
. Inspection/Php/stats.sh

# Linting
. Inspection/Php/linting.sh
. Inspection/Json/linting.sh

# Custom html inspections
. Inspection/Html/tags.sh
. Inspection/Html/attributes.sh

# Custom php inspections
. Inspection/Php/security.sh
