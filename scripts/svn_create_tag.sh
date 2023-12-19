#!/usr/bin/env zsh

#
#  svn_create_tag.sh
#  material-board
#
#  Created by Fatih Balsoy on 15 Dec 2023
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..
if [[ -z "$SCRIPTPATH" ]]; then
    echo "SCRIPTPATH is empty. Exiting."
    exit 1
fi

build_path="$SCRIPTPATH/build/"
svn_path="$SCRIPTPATH/svn/"
if [[ ! -d "$build_path" || ! -d "$svn_path" ]]; then
    echo "Build or SVN path does not exist. Exiting."
    exit 1
fi

source $SCRIPTPATH/scripts/plugin_info.sh
PLUGIN_ZIP_NAME="${PLUGIN_BUNDLE}-${PLUGIN_VERSION}"
echo "$PLUGIN_ZIP_NAME"

tag_path="$SCRIPTPATH/svn/tags/$PLUGIN_VERSION/"
if [[ -d "$tag_path" ]]; then
    echo "Tag for $PLUGIN_VERSION already exists! Exiting."
    exit 1
fi

echo "Bundling plugin..."
npm run build

echo "Clearing trunk..."
rm -rf "$SCRIPTPATH/svn/trunk/"
mkdir -p "$SCRIPTPATH/svn/trunk/"
echo "Creating tag..."
mkdir -p "$SCRIPTPATH/svn/tags/$PLUGIN_VERSION"
echo "Copying files..."
cp -ar "$build_path/$PLUGIN_BUNDLE/." "$SCRIPTPATH/svn/tags/$PLUGIN_VERSION"
cp -ar "$build_path/$PLUGIN_BUNDLE/." "$SCRIPTPATH/svn/trunk"

echo "Done."