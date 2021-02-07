#!/bin/bash

if [ $# -eq 0 ]
then
    echo "    Syntax:" $(basename -- "$0") "[pull request number]"
    exit
fi

clear

svn revert -R phpnet/pt_BR
svn update phpnet/

php src/synctest.php https://github.com/phpdocbrbridge/traducao/pull/"$1".diff phpnet/pt_BR 1
php phpnet/doc-base/configure.php --silent --enable-xml-details --with-lang=pt_BR

svn status phpnet/pt_BR > status.txt
svn diff   phpnet/pt_BR > diff.txt

echo "In en:"
svn status phpnet/en
echo "In pt_BR:"
svn status phpnet/pt_BR

echo
stat -c "%n %s" status.txt
stat -c "%n %s" diff.txt

echo
echo "If ok, merge on GitHub and then:"
echo
echo "    svn commit -m \"Translations by @NAME - https://github.com/phpdocbrbridge/traducao/pull/$1\" phpnet/pt_BR/"
echo
