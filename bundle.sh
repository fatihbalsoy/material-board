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
PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_bundle =")
IFS='"'; set $PLUGIN_BUNDLE_LINE; php_var=$1; PLUGIN_BUNDLE=$2
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_version =")
IFS='"'; set $PLUGIN_VERSION_LINE; php_var=$1; PLUGIN_VERSION=$2

PLUGIN_ZIP_NAME="$PLUGIN_BUNDLE-$PLUGIN_VERSION"
echo "$PLUGIN_ZIP_NAME"

#?#   Setup Build Directory   #?#
echo "Setting up build directory..."
rm -rf $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/logs/

#?#   Copy Files   #?#
echo "Copying files..."
cp $SCRIPTPATH/README.md build/
cp $SCRIPTPATH/LICENSE build/
rsync -avz --prune-empty-dirs --exclude-from=$SCRIPTPATH/.bundleignore $SCRIPTPATH/src/ $SCRIPTPATH/build/ >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log

#?#   Compiling Sass and Typescript Files   #?#
echo "Compiling Sass Files..."
sass src/:build/ --no-source-map --style compressed
echo "Compiling Typescript Files..."
tsc

#?#   Zip Files   #?#
echo "Archiving..."
mkdir -p $SCRIPTPATH/build/_bundle/$PLUGIN_BUNDLE
rsync -avz --prune-empty-dirs $SCRIPTPATH/build/. $SCRIPTPATH/build/_bundle/$PLUGIN_BUNDLE >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
cd $SCRIPTPATH/build/_bundle
zip -r ./$PLUGIN_ZIP_NAME.zip $PLUGIN_BUNDLE >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
cd - >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log

#?#   Unzip files to verify match   #?#
unzip $SCRIPTPATH/build/_bundle/$PLUGIN_ZIP_NAME.zip -d $SCRIPTPATH/build/_bundle/$PLUGIN_ZIP_NAME/ >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log

echo "Done."