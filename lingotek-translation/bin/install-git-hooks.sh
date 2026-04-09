#!/usr/bin/env bash

# Switch to git root directory
git_root=`git rev-parse --show-toplevel`
cd $git_root

# Add hook if necessary
if [ ! -f .git/hooks/prepare-commit-msg ];
then
    echo 'Adding commit message hook.'
    cp ./bin/githook-prepare-commit-msg.sh .git/hooks/prepare-commit-msg \
        && echo '***Commit message hook added successfully.***'
else
    echo 'Commit message hook already in place. Not overwriting.'
fi

if [ ! -f .git/hooks/pre-commit ];
then
    echo 'Adding pre-comit hook.'
    cp ./bin/githook-pre-commit.sh .git/hooks/pre-commit \
        && echo '***Pre-commit hook added successfully.***'
else
    echo 'Pre-commit hook already in place. Not overwriting.'
fi

