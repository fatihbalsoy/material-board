#!/usr/bin/env zsh

#
#  bundle.sh
#  scripts
#
#  Created by Fatih Balsoy on 4/14/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..
if [[ -z "$SCRIPTPATH" ]]; then
    echo "SCRIPTPATH is empty. Exiting..."
    exit 1
fi

echo "=============================================================" >> $SCRIPTPATH/logs/out.log >> $SCRIPTPATH/logs/err.log
date >> $SCRIPTPATH/logs/out.log >> $SCRIPTPATH/logs/err.log

if [ ! -n "$ZSH_VERSION" ]; then
    echo "Please run script with zsh. Exiting."
    exit 1
fi

#?#   Plugin Name and Version   #?#
source $SCRIPTPATH/scripts/plugin_info.sh
PLUGIN_ZIP_NAME="${PLUGIN_BUNDLE}-${PLUGIN_VERSION}"
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
bash $SCRIPTPATH/scripts/copy_files.sh

#?#   Compiling Language Files   #?#
zsh $SCRIPTPATH/scripts/compile_languages.sh

#?#   Compiling Sass and Typescript Files   #?#
echo "Compiling Sass Files..."
sass $SCRIPTPATH/src/:$SCRIPTPATH/build/ --no-source-map --style compressed
echo "Compiling Typescript Files..."
tsc --declaration false
echo "Compressing Javascript Files..."
# Find all JavaScript files recursively and loop over them
find $SCRIPTPATH/build/ -type f -name "*.js" -print0 | while IFS= read -r -d '' file; do
    # Compress each file
    uglifyjs --compress --mangle --mangle-props -o $file -- $file
done

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
