#!/bin/bash

PRODUCT=php-mesh
VERSION=1.4-alpha1

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

rm -rf $TEMPDIR
mkdir -p $TEMPDIR

cp -R CHANGES LICENSE README *.php docs example tests $TEMPDIR
#TODO: Make this work for more recursion.
rm -rf `find $TEMPDIR -name .svn`

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

