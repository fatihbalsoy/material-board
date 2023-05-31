#!/usr/bin/env zsh

#
#  bundle.sh
#  scripts
#
#  Created by Fatih Balsoy on 4/14/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"

if [ ! -n "$ZSH_VERSION" ]; then
    echo "Please run script with zsh. Exiting."
    exit 1
fi

#?#   Plugin Name and Version   #?#
PLUGIN_BUNDLE_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_bundle =")
PLUGIN_BUNDLE=${${PLUGIN_BUNDLE_LINE%\"*}#*\"}
PLUGIN_VERSION_LINE=$(cat $SCRIPTPATH/src/wp-material-design.php | grep "\$fb_mdp_plugin_version =")
PLUGIN_VERSION=${${PLUGIN_VERSION_LINE%\"*}#*\"}

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
bash $SCRIPTPATH/copy_files.sh

#?#   Compiling Language Files   #?#
if ! command -v msgfmt &> /dev/null || ! [[ -x "$(command -v msgfmt)" ]]; then
    echo "Language (*.po) compilation skipped: msgfmt command is not installed or not executable."
else
    mkdir -p $SCRIPTPATH/build/languages # rsync skips empty directories
    echo "Compiling Language Files..."
    echo "Duplicating Language Files..."

    # Define the dictionary of language codes
    typeset -A dictionary=()
    dictionary["fr_FR"]="fr_CA"
    dictionary["de_DE"]="de_AT de_CH de_DE_formal de_DE_informal"

    # Loop through all .po files in the src/languages directory
    for po_file in $SCRIPTPATH/src/languages/*.po; do
        # Extract the language code from the filename
        filename=$(basename "$po_file")
        lang_code=${filename#$PLUGIN_BUNDLE-}
        lang_code=${lang_code%.po}
        filename=$(basename "$po_file")
        filename=${filename%.po}

        # Compile the .po file using msgfmt
        echo "Compiling src/lang/${filename}.po -> build/lang/${filename}.mo" >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
        msgfmt "$po_file" -o "$SCRIPTPATH/build/languages/${filename}.mo"

        # Check if the language code exists in the dictionary
        variant_list=${dictionary["$lang_code"]}
        if [ -n "$variant_list" ]; then
            echo "* $lang_code -> $variant_list"
            variant_codes=(${=variant_list})

            # Duplicate and rename the .mo file for each variant
            for variant_code in $variant_codes; do
                variant_parent_file="$SCRIPTPATH/build/languages/${PLUGIN_BUNDLE}-${lang_code}.mo"
                variant_mo_file="$SCRIPTPATH/build/languages/${PLUGIN_BUNDLE}-${variant_code}.mo"
                echo "Duplicating $lang_code -> $variant_code" >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
                cp "$variant_parent_file" "$variant_mo_file"
            done
        fi
    done
fi

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
