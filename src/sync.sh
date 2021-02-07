#!/bin/bash

clear
svn update github/pt_BR
svn update phpnet/doc-base
svn update phpnet/en
svn update phpnet/pt_BR

echo
echo SVN status
echo "In en:"
svn status phpnet/en
echo "In pt_BR:"
svn status phpnet/pt_BR

echo
echo Differences
diff -r --exclude=".svn" --exclude="README.md" phpnet/pt_BR github/pt_BR

echo
echo Files without svn:keywords
fgrep -lr --exclude-dir=.svn '$Revision$' phpnet/en/

# If any, then:
# svn propset svn:keywords 'Id Rev Revision Date LastChangedDate LastChangedRevision Author LastChangedBy HeadURL URL' file
# svn commit -m "Files without svn:keywords Revision" phpnet/en/

echo
echo Done
