#!/bin/bash

PRODUCT=php-mesh
VERSION=1.3-alpha2

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

rm -rf $TEMPDIR
mkdir -p $TEMPDIR

cp -R CHANGES LICENSE README *.php docs example tests $TEMPDIR
#TODO: Make this work for more recursion.
rm -rf $TEMPDIR/docs/.svn
rm -rf $TEMPDIR/example/.svn
rm -rf $TEMPDIR/tests/.svn

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

