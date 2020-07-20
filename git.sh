#!/bin/bash

if [ -z $1 ]; then
    str='太懒，没写备注！'
else
    str=$1
fi


git add -A
git commit -m "$str"
git push
