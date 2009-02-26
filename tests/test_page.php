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
    require_once("../Page.class.php");

    $page = new Page(<<<ENDHTML
<html>
  <head>
    <title>Information about widgets</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
    <meta name="Keywords" content="widgets, stuff"/>
    <style type="text/css"><!-- style --></style>
  </head>
  <body class="information"><p>The body of the page.</p></body>
</html>
ENDHTML
);

    ob_start();
    $page->title();
    assert_equals("Information about widgets", ob_get_clean());

    ob_start();
    $page->property("meta.Content-Type");
    assert_equals("text/html; charset=utf8", ob_get_clean());

    ob_start();
    $page->property("meta.Content-Type", NULL, TRUE);
    assert_equals("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8\" />", ob_get_clean());

    ob_start();
    $page->property("meta.Keywords");
    assert_equals("widgets, stuff", ob_get_clean());

    ob_start();
    $page->property("meta.Keywords", NULL, TRUE);
    assert_equals("<meta name=\"Keywords\" content=\"widgets, stuff\" />", ob_get_clean());

    ob_start();
    $page->property("body.class");
    assert_equals("information", ob_get_clean());

    ob_start();
    $page->property("body.class", NULL, TRUE);
    assert_equals(" class=\"information\"", ob_get_clean());

    ob_start();
    $page->property("meta.Nonexistent", "default");
    assert_equals("default", ob_get_clean());

    $remaining_head = trim(<<<ENDHTML
    <meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
    <meta name="Keywords" content="widgets, stuff"/>
    <style type="text/css"><!-- style --></style>
ENDHTML
);

    ob_start();
    $page->head();
    assert_equals($remaining_head, trim(ob_get_clean()));

    ob_start();
    $page->body();
    assert_equals("<p>The body of the page.</p>", trim(ob_get_clean()));

?>
