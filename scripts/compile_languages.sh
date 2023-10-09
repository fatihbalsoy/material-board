#!/usr/bin/env zsh

#
#  compile_languages.sh
#  material-design-dashboard
#
#  Created by Fatih Balsoy on 5/31/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..
source $SCRIPTPATH/scripts/plugin_info.sh

#?#   Compiling Language Files   #?#
if ! command -v msgfmt &> /dev/null || ! [[ -x "$(command -v msgfmt)" ]]; then
    echo "Language (*.po) compilation skipped: msgfmt command is not executable. Install gettext."
else
    mkdir -p $SCRIPTPATH/build/languages # rsync skips empty directories
    echo "Compiling Language Files..."
    echo "Duplicating Language Files..."

    # Define the dictionary of language codes
    typeset -A dictionary=()
    dictionary["fr_FR"]="fr_CA"
    dictionary["de_DE"]="de_AT de_CH de_DE_formal de_DE_informal"
    dictionary["en_GB"]="en_CA en_NZ en_AU en_ZA"

    # Loop through all .po files in the src/languages directory
    for po_file in $SCRIPTPATH/src/languages/*.po; do
        if [[ $(basename $po_file) == "source.po" ]]; then
            continue # Skip source file
        fi
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