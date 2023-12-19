#!/usr/bin/env zsh

#
#  copy_files.sh
#  scripts
#
#  Created by codespace on 5/24/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..
source $SCRIPTPATH/scripts/plugin_info.sh
if [[ -z "$PLUGIN_BUNDLE" ]]; then
    echo "PLUGIN_BUNDLE is empty. Exiting..."
    exit 1
fi

# ? Copy rest of the files ? #
rsync -avzu --prune-empty-dirs --exclude-from=$SCRIPTPATH/.bundleignore $SCRIPTPATH/src/ $SCRIPTPATH/build/$PLUGIN_BUNDLE/ >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
