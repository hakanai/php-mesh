<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright © 2003  Trejkaz Xaoza

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

    // Include user configuration from the base web directory.
    // Redundant right now because we don't use any configuration here.
    //require_once("${DOCUMENT_ROOT}/.phpmeshrc");

    // Bunch of crap to disable caching.
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                // Date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   // always modified
    header("Cache-Control: no-store, no-cache, must-revalidate");    // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");                                      // HTTP/1.0

    // Now we have to scrape the useful stuff out of the page...
    $matches = array();

    // Use output buffering to read the page into a string.
    ob_start();

    // The real page will occur next because this file is the header.
?>
