#!/usr/bin/env bash

PROJECT=`git rev-parse --show-toplevel`
STAGED_FILES_CMD=`git diff --cached --name-only --diff-filter=ACMR HEAD | grep \\\\.php`
# This is valid for roots/bedrock, not for standard WordPress.
DOCKER_BASE_PATH='/var/www/html/web/app/plugins/lingotek-translation/'

# Determine if a file list is passed
if [ "$#" -eq 1 ]
then
    SFILES = "$*"
fi
SFILES=${SFILES:-$STAGED_FILES_CMD}

echo "Checking PHP Lint..."
for FILE in $SFILES
do
    ddev exec bash -c "php -l -d display_errors=0 $DOCKER_BASE_PATH/$FILE"
    if [ $? != 0 ]
    then
       echo "Fix the error before commit."
       exit 1
    fi
    FILES="$FILES $PROJECT/$FILE"
done

if [ "$FILES" != "" ]
then
    echo "Running Code Sniffer..."
    phpcs --standard=phpcs.xml --encoding=utf-8 $FILES
    if [ $? != 0 ]
    then
       echo 'We are allowing the commit, but take into account the warnings above.'
       #echo "Fix the error before commit."
       #exit 1
    fi
fi
