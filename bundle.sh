#!/usr/bin/env bash

#
#  bundle.sh
#  scripts
#
#  Created by Fatih Balsoy on 4/14/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"

PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/index.php | grep fb_mdp_plugin_version)
IFS='"'; set $PLUGIN_VERSION_LINE; php_var=$1; PLUGIN_VERSION=$2
echo $PLUGIN_VERSION
PLUGIN_ZIP_NAME="wp-material-design-$PLUGIN_VERSION"

echo "Bundling plugin: $PLUGIN_ZIP_NAME"

rm -rf $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/contents/
mkdir -p $SCRIPTPATH/build/logs/

rsync -avz --prune-empty-dirs \
    --exclude '.DS_Store' \
    --exclude '.readme/' \
    --exclude '.git/' \
    --exclude '.github/' \
    --exclude '.vscode/' \
    --exclude 'build/' \
    --exclude 'docs/' \
    --exclude 'volumes/' \
    --exclude '.gitignore' \
    --exclude 'bundle.sh' \
    --exclude 'docker-compose.yaml' \
    $SCRIPTPATH/. $SCRIPTPATH/build/contents/ >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log

cd $SCRIPTPATH/build/contents/
zip -r ../$PLUGIN_ZIP_NAME.zip . >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log
cd -

unzip $SCRIPTPATH/build/$PLUGIN_ZIP_NAME.zip -d $SCRIPTPATH/build/$PLUGIN_ZIP_NAME/ >> $SCRIPTPATH/build/logs/out.log 2>> $SCRIPTPATH/build/logs/err.log
