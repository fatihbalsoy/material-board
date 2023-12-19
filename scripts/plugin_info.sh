#!/usr/bin/env zsh

#
#  plugin_info.sh
#  material-board
#
#  Created by Fatih Balsoy on 5/31/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..
if [[ -z "$SCRIPTPATH" ]]; then
    echo "SCRIPTPATH is empty. Exiting..."
    exit 1
fi

PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/src/material-board.php | grep "\$fbwpmdp_bundle =")
PLUGIN_BUNDLE=${${PLUGIN_BUNDLE_LINE%\"*}#*\"}
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/src/readme.txt | grep "Stable tag: ")
PLUGIN_VERSION=$(echo $PLUGIN_VERSION_LINE | sed 's/.*Stable tag: //')