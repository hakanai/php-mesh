#!/bin/bash

PRODUCT=php-mesh
VERSION=0.1

TEMPDIR=${PRODUCT}-${VERSION}
ARCHIVE=${PRODUCT}-${VERSION}.tar.gz

mkdir -p $TEMPDIR

cat LICENSE.preamble README > $TEMPDIR/README
cp LICENSE $TEMPDIR

for f in *.php ; do
    echo "<?php /*" > $TEMPDIR/$f
    cat LICENSE.preamble >> $TEMPDIR/$f
    echo "*/ ?>" >> $TEMPDIR/$f
    cat $f >> $TEMPDIR/$f
done

tar zcf $ARCHIVE $TEMPDIR

rm -rf $TEMPDIR

