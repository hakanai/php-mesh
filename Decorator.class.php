<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright ? 2003  Trejkaz

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

require_once('Page.class.php');

/**
 * This class is a wrapper around a decorator file to make calling it easier.
 *
 * @author Trejkaz <trejkaz@trypticon.org>
 */
class Decorator
{
    // The decorator filename.
    // This variable is prone to change so don't use it directly.
    var $_decorator_filename;

    /**
     * Creates the decorator.
     *
     * @param $decorator_filename the decorator filename.
     */
    function Decorator($decorator_filename)
    {
        $this->_decorator_filename = $decorator_filename;
    }

    /**
     * Perform decoration.
     *
     * @param $page the Page to decorate.
     */
    function decorate($page)
    {
        include($this->_decorator_filename);
    }
}

?>
