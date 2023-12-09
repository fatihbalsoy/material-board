#!/usr/bin/env zsh

#
#  plugin_info.sh
#  material-board
#
#  Created by Fatih Balsoy on 5/31/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/src/material-board.php | grep "\$fbwpmdp_bundle =")
PLUGIN_BUNDLE=${${PLUGIN_BUNDLE_LINE%\"*}#*\"}
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/src/material-board.php | grep "\$fbwpmdp_version =")
PLUGIN_VERSION=${${PLUGIN_VERSION_LINE%\"*}#*\"}