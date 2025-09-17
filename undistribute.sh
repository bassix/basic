#!/bin/bash

# Include bash base scripts
. bin/_base.sh
. bin/_colors.sh

#mapfile -t targets < .distribute
#readarray -t targets < .distribute
targets=($(cat ".distribute"))

for target in "${targets[@]}"
do
    if [ -d "$target" ]
    then
        read -p "Do you want to delete \"$target\" (y/n)? " doRsync
        if [ "$doRsync" == "y" ]
        then
            mkdir ".empty"
            rsync -avhr --delete .empty/ "$target"
            rm -rf ".empty"
        else
            echo "rsync to \"$target\" aborted!"
        fi
    else
        echo "The configured target \"$target\" does not exist!"
    fi
done
