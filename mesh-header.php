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

    // Include the various classes which make up the system.
    require_once("Page.class.php");
    require_once("Decorator.class.php");
    require_once("DecoratorSelector.class.php");

    // Create the object which will locate the decorators.
    $decorator_selector = new DecoratorSelector();

    // Get the decorator using the optional 'decorator' parameter specified in the URL.
    if (! @isset($_GET["decorator"]))
    {
        // Will use the default.
        $decorator = $decorator_selector->get_decorator(NULL);
    }
    else if ($_GET["decorator"] == "identity")
    {
        $decorator = NULL;
    }
    else
    {
        $decorator = $decorator_selector->get_decorator($_GET["decorator"]);
    }

    // Bypass decoration entirely, for the identity decorator.
    if ($decorator != NULL)
    {
        // Bunch of crap to disable caching.
        // TODO: Decide whether this should perhaps go elsewhere.
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                // Date in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   // always modified
        header("Cache-Control: no-store, no-cache, must-revalidate");    // HTTP/1.1
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");                                      // HTTP/1.0

        // Use output buffering to read the page into a string.
        ob_start();
    }

    // The real page will occur next because this file is the header.
?>
