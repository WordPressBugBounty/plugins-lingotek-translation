#!/usr/bin/env bash

# Get git repository information
commit_msg_file=$1
commit_type=$2
commit_branch=`git symbolic-ref --short HEAD`
raw_ticket_num=`echo $commit_branch | grep -oh -E '^[a-zA-Z]+-{0,1}[0-9]+'`
ticket_num=`echo $raw_ticket_num | sed  -E 's,^([a-zA-Z]+)([0-9]+).*,\1-\2,1'`

if [ "${commit_type}" = "merge" ];then
    exit 0
fi
# Check if branch begins with a valid ticket number
if [ -z "$ticket_num"  ];
then
    read -p \
    "Please enter the ticket number in the format XX-####: " \
    ticket_num </dev/tty
fi

VALID_TICKET=`echo $ticket_num | grep -oh -E '^[a-zA-Z]+-[0-9]+'`

# Check user-entered value or previously captured ticket number to make sure it conforms
if [ -z "$VALID_TICKET" ];
then
    echo 'Invalid ticket number. Please try to commit again'
    exit 1
fi

# Create commit message
issue_string="Issue #$ticket_num:"
# Keep all newlines in captured commit message
IFS=
raw_commit_msg="$(cat $commit_msg_file)"
commit_msg="$issue_string $raw_commit_msg"
echo $commit_msg > $commit_msg_file

if [ "$commit_type" = "message" ];
then
	commit_msg="$issue_string $raw_commit_msg"
else
	commit_msg=`echo -e "$issue_string\n\n$raw_commit_msg"`
fi

# Store new commit message
echo $commit_msg > $commit_msg_file
