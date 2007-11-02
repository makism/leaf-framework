#!/bin/sh

WORKING_DIR=.

if [ -d "$WORKING_DIR" ]; then
    # add items that are not under revision control
    svn status | awk '$1=="?" { system("svn add \"" $2 "\" ") }'

    # remove items that are missing
    svn status | awk '$1=="!" { system("svn delete \"" $2 "\" ") }'

    # svn ci --non-interactive --quit
fi

