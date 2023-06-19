#!/usr/bin/env zsh

#
#  bundle_languages.sh
#  material-design-dashboard
#
#  Created by Fatih Balsoy on 6/18/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..

zsh $SCRIPTPATH/scripts/bundle.sh
source $SCRIPTPATH/scripts/plugin_info.sh

mkdir -p $SCRIPTPATH/build/_bundle/languages
cd $SCRIPTPATH/build/_bundle
echo "Archiving for each language..."
zip -r ./languages/$PLUGIN_ZIP_NAME.zip $PLUGIN_BUNDLE -x $PLUGIN_BUNDLE/languages/* >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
for FILE in $PLUGIN_BUNDLE/languages/*.mo; do
    # Extract the language code from the file name
    LANG_FILE=$(basename "$FILE" .mo)
    LANG_ZIP_FILE="./languages/$LANG_FILE-$PLUGIN_VERSION.zip"
    echo "* $LANG_FILE"

    # Create the language-specific zip file
    cp ./languages/$PLUGIN_ZIP_NAME.zip $LANG_ZIP_FILE
    zip -ur $LANG_ZIP_FILE $FILE >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
done
rm ./languages/$PLUGIN_ZIP_NAME.zip
cd - >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log

echo "Done."