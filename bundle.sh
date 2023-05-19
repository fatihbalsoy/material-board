#!/usr/bin/env bash

#
#  bundle.sh
#  scripts
#
#  Created by Fatih Balsoy on 4/14/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"

#?#   Plugin Name and Version   #?#
PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/index.php | grep "\$fb_mdp_plugin_bundle =")
IFS='"'; set $PLUGIN_BUNDLE_LINE; php_var=$1; PLUGIN_BUNDLE=$2
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/index.php | grep "\$fb_mdp_plugin_version =")
IFS='"'; set $PLUGIN_VERSION_LINE; php_var=$1; PLUGIN_VERSION=$2

PLUGIN_ZIP_NAME="$PLUGIN_BUNDLE-$PLUGIN_VERSION"
echo "$PLUGIN_ZIP_NAME"

#?#   Setup Build Directory   #?#
echo "Setting up build directory..."
rm -rf $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/$PLUGIN_BUNDLE/
mkdir -p $SCRIPTPATH/build/logs/

#?#   Copy Files   #?#
echo "Copying files..."
rsync -avz --prune-empty-dirs --exclude-from=$SCRIPTPATH/.bundleignore $SCRIPTPATH/. $SCRIPTPATH/build/$PLUGIN_BUNDLE/ >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log

#?#   Zip Files   #?#
echo "Archiving..."
cd $SCRIPTPATH/build/
zip -r ./$PLUGIN_ZIP_NAME.zip $PLUGIN_BUNDLE/ >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log
cd - >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log

#?#   Unzip files to verify match   #?#
unzip $SCRIPTPATH/build/$PLUGIN_ZIP_NAME.zip -d $SCRIPTPATH/build/$PLUGIN_ZIP_NAME/ >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log

echo "Done."