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

    // Include the page parsing class.
    require_once("Mesh.class.php");

    // Include user configuration from the root of the web directory.
    require_once("${DOCUMENT_ROOT}/.phpmeshrc");

    // The real page just occurred because this is the footer.
    $pageContent = ob_get_contents();
    ob_end_clean();

    // Create the page object.  This guy does all the parsing work.
    $mesh = new Mesh($pageContent);

    // Determine which decorator to use.

    // First, see if a 'decorator' parameter was specified in the URL.
    $decorator_name = $HTTP_GET_VARS["decorator"];
    if ($decorator_name == '' || preg_match("/^\w+$/", $decorator_name) != 1)
    {
        // No parameter was specified, so use the default.
        $decorator_name = $meshconfig{'decorator_default'};
    }

    // Now make sure the decorator exists.
    $decorator_filename = $DOCUMENT_ROOT . '/' . $meshconfig{'decorator_directory'} . '/' . $decorator_name;
    if (!file_exists($decorator_filename))
    {
        // The file did not exist, so use the default. 
        $decorator_filename = $DOCUMENT_ROOT . '/' . $meshconfig{'decorator_directory'} . '/' . $meshconfig{'decorator_default'};
    }

    // Now include.  If it's using the default, we hope it exists.
    include("${DOCUMENT_ROOT}/decorators/${decorator_name}.php");

?>

