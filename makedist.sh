#!/bin/bash

PRODUCT=php-mesh
VERSION=0.1

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

rm -rf $TEMPDIR
mkdir -p $TEMPDIR

cp -R LICENSE README *.php example $TEMPDIR

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

