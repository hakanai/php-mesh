<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright ? 2004  Trejkaz Xaoza

    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

    You can contact the author by electronic mail, which is presently
    at the following address: trejkaz@xaoza.net
*/

    require_once("../utils.php");

    assert_options(ASSERT_ACTIVE, 1);
    assert_options(ASSERT_WARNING, 1);

    $is_windows = (PHP_OS == 'WINNT' || PHP_OS == 'WIN32');

    // Tests of the is_absolute function.
    assert(is_absolute("fish") == FALSE);
    assert(is_absolute("fish/pants") == FALSE);
    assert(is_absolute("c:/") == $is_windows);
    assert(is_absolute("d:\\") == $is_windows);
    assert(is_absolute("E:/") == $is_windows);
    assert(is_absolute("F:\\") == $is_windows);
    assert(is_absolute("/") == TRUE);
    assert(is_absolute("\\") == $is_windows);

    // Tests of the resolve_path function.
    //TODO: Unit tests for Windows, but I require a Windows environment for this.
    if (!$is_windows)
    {
        assert(resolve_path("/", "/tmp") == "/tmp");
        assert(resolve_path("/", "tmp") == "/tmp");
        assert(resolve_path("/tmp", "../var") == "/var");
        assert(resolve_path("/tmp", ".") == "/tmp");
    }
?>
