#!/usr/bin/env bash

#
#  copy_files.sh
#  scripts
#
#  Created by codespace on 5/24/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"
src_dir="$SCRIPTPATH/src"
build_dir="$SCRIPTPATH/build"


# ? Duplicate Languages ? #
echo "Duplicating languages..."
mkdir -p $build_dir/languages
source_languages=(
    "fr_FR" 
    "de_DE" "de_DE" "de_DE" "de_DE"
)
target_languages=(
    "fr_CA"
    "de_AT" "de_DE_formal" "de_DE_informal" "de_CH"
)

for ((i=0; i<${#source_languages[@]}; i++)); do
    source_lang="${source_languages[$i]}"
    target_lang="${target_languages[$i]}"
    echo " - $source_lang -> $target_lang"

    cp "$src_dir"/languages/*-"$source_lang".mo "$build_dir"/languages/
    for file in "$build_dir"/languages/*-"$source_lang".mo; do
        new_file="${file//$source_lang/$target_lang}"
        mv "$file" "$new_file"
    done
done

# ? Copy rest of the files ? #
rsync -avz --prune-empty-dirs --exclude-from=$SCRIPTPATH/.bundleignore $SCRIPTPATH/src/ $SCRIPTPATH/build/ >> $SCRIPTPATH/logs/out.log 2>> $SCRIPTPATH/logs/err.log
