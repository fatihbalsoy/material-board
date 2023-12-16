#!/usr/bin/env bash

#
#  multilingual_markdown.sh
#  material-board
#
#  Created by Fatih Balsoy on 6/19/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"/..

cd $SCRIPTPATH/.readme/lang/

if ! command -v mmg &> /dev/null || ! [[ -x "$(command -v mmg)" ]]; then
    echo "Multilingual Markdown CLI (mmg) is not installed or not executable."
    echo "Download mmg here: https://github.com/ryul1206/multilingual-markdown"
else
    mmg README.base.md --yes
    mmg SETUP.base.md --yes
fi

cd $SCRIPTPATH

mv $SCRIPTPATH/.readme/lang/README.md .
mv $SCRIPTPATH/.readme/lang/SETUP.md .