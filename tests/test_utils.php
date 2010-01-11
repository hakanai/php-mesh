<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright (C) 2003-2009  Trejkaz

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
    at the following address: trejkaz@trypticon.org
*/

    require_once("assert.php");
    require_once("../utils.php");

    $is_windows = (PHP_OS == 'WINNT' || PHP_OS == 'WIN32');

    // Tests of the is_absolute function.
    // UNIX
    assert_equals(FALSE, is_absolute("fish", FALSE));
    assert_equals(FALSE, is_absolute("fish/pants", FALSE));
    assert_equals(TRUE, is_absolute("/", FALSE));
    // Windows
    assert_equals(FALSE, is_absolute("fish", FALSE));
    assert_equals(FALSE, is_absolute("fish/pants", FALSE));
    assert_equals(FALSE, is_absolute("fish\\pants", FALSE));
    assert_equals(TRUE, is_absolute("c:/", TRUE));
    assert_equals(TRUE, is_absolute("d:\\", TRUE));
    assert_equals(TRUE, is_absolute("E:/", TRUE));
    assert_equals(TRUE, is_absolute("F:\\", TRUE));
    assert_equals(TRUE, is_absolute("\\", TRUE));

    // Tests of the resolve_path function.
    //TODO: Unit tests for Windows, but I require a Windows environment for this.
    if (!$is_windows)
    {
        assert_equals(realpath("/tmp"), resolve_path("/", "/tmp"));
        assert_equals(realpath("/tmp"), resolve_path("/", "tmp"));
        assert_equals(realpath("/var"), resolve_path("/tmp", "../var"));
        assert_equals(realpath("/tmp"), resolve_path("/tmp", "."));
    }

    // Tests of the chop_last function.
    assert_equals("", chop_last("/"));
    assert_equals("/", chop_last("/foo"));
    assert_equals("/", chop_last("/foo/"));
    assert_equals("/longer/", chop_last("/longer/path"));
    assert_equals("/longer/", chop_last("/longer/path/"));

    // Tests of the chop_file function.
    assert_equals("/", chop_file("/"));
    assert_equals("/", chop_file("/foo"));
    assert_equals("/foo/", chop_file("/foo/"));
    assert_equals("/longer/", chop_file("/longer/path"));
    assert_equals("/longer/path/", chop_file("/longer/path/"));
    
    // Tests of the find_nearest function.  This can't test with Apache, unfortunately...
    assert_equals(realpath("test_utils.php"), find_nearest("test_utils.php"));
    assert_equals(realpath("../utils.php"), find_nearest("utils.php"));
    assert_equals(NULL, find_nearest("bogus_file.php"));

    // Tests of the parse_http_accept_language function.
    assert_equals(array("en-US"), parse_http_accept_language("en-US"));
    assert_equals(array("en-US", "en"), parse_http_accept_language("en-US,en;q=0.8"));
    assert_equals(array("en-US", "en"), parse_http_accept_language("en;q=0.8,en-US"));
    assert_equals(array("en-AU", "en-GB", "en"), parse_http_accept_language("en-AU,en-GB;q=0.8,en;q=0.6"));

?>
