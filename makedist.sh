#!/bin/bash

PRODUCT=php-mesh
VERSION=0.5

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

rm -rf $TEMPDIR
mkdir -p $TEMPDIR

cp -R CHANGES LICENSE README *.php example $TEMPDIR
#TODO: Make this work for more recursion.
rm -rf $TEMPDIR/example/CVS

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

