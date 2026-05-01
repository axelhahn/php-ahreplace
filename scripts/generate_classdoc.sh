#!/bin/bash

cd "$( dirname "$0" )/../"
APPDIR="$( pwd )"

echo "APPDIR: $APPDIR"
cd "$( dirname $0)/../../php-classdoc"

./parse-class.php --debug --out md $APPDIR/src/replace-tags.class.php > $APPDIR/docs/99_Classes/replace-tags.class.php.md
