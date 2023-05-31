#!/usr/bin/env zsh

#
#  plugin_info.sh
#  material-design-dashboard
#
#  Created by Fatih Balsoy on 5/31/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_bundle =")
PLUGIN_BUNDLE=${${PLUGIN_BUNDLE_LINE%\"*}#*\"}
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_version =")
PLUGIN_VERSION=${${PLUGIN_VERSION_LINE%\"*}#*\"}