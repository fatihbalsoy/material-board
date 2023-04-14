#
#  bundle.sh
#  scripts
#
#  Created by Fatih Balsoy on 4/14/23
#  Copyright © 2023 Fatih Balsoy. All rights reserved.
#

SCRIPTPATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 ; pwd -P )"

rm -rf $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/
mkdir -p $SCRIPTPATH/build/contents/

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
    $SCRIPTPATH/. $SCRIPTPATH/build/contents/

cd $SCRIPTPATH/build/contents/
zip -r ../wp-material-design.zip .
cd -

unzip $SCRIPTPATH/build/wp-material-design.zip -d $SCRIPTPATH/build/wp-material-design/
