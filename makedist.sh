#!/bin/bash

PRODUCT=php-mesh
VERSION=1.2.2

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

rm -rf $TEMPDIR
mkdir -p $TEMPDIR

cp -R CHANGES LICENSE README *.php docs example tests $TEMPDIR
#TODO: Make this work for more recursion.
rm -rf $TEMPDIR/docs/CVS
rm -rf $TEMPDIR/example/CVS
rm -rf $TEMPDIR/tests/CVS

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

