<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright ? 2003  Trejkaz Xaoza

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

    // The real page just occurred because this is the footer.
    $page_content = ob_get_contents();
    ob_end_clean();

    // Create the page object.  This guy does all the parsing work.
    $page = new Page($page_content);

    // Get the decorator using the optional 'decorator' parameter specified in the URL.
    if (@isset($HTTP_GET_VARS["decorator"]))
    {
        $decorator = $decorator_selector->get_decorator($HTTP_GET_VARS["decorator"]);
    }
    else
    {
        // Will use the default.
        $decorator = $decorator_selector->get_decorator(NULL);
    }

    // Perform the decoration.
    $decorator->decorate($page);

?>
