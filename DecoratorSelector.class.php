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

require_once('Decorator.class.php');
require_once('utils.php');

/**
 * This class defines objects which are capable of locating decorator files
 * given the decorators' names.  It does this using the .phpmeshrc configuration
 * file in the document root.
 *
 * @author Trejkaz Xaoza <trejkaz@xaoza.net>
 */
class DecoratorSelector
{
    // The name of the default decorator.
    // This variable is prone to change, so don't use it directly.
    var $_default_decorator_name;

    // The location of the decorator directory.
    // This variable is prone to change, so don't use it directly.
    var $_decorator_directory;

    /**
     * Creates the decorator selector, reading the .phpmeshrc file from
     * the document root to provide its configuration.
     */
    function DecoratorSelector()
    {
        // Protect against Random Q. User inserting space in his config file.
        ob_start();
        require($_SERVER['DOCUMENT_ROOT'] . '/.phpmeshrc');
        ob_end_clean();

        // Get the name of the default decorator.
        $this->_default_decorator_name = $meshconfig{'decorator_default'};

        // Resolve the decorator directory relative to the document root.
        $this->_decorator_directory = resolve_path($_SERVER['DOCUMENT_ROOT'], $meshconfig{'decorator_directory'});
    }

    /**
     * Gets the absolute path to a file for the given filename, which may be relative.
     * The path is resolved relative to the decorator directory.
     *
     * @param $path the path to the file, relative or absolute.
     * @return the absolute path to the file.
     */
    function get_path($path)
    {
        return resolve_path($this->_decorator_directory, $path);
    }

    /**
     * Gets a Decorator object for the given name.
     * If the name is not provided, gets the default decorator.  If the decorator
     * requested is not found, the default is used instead (assuming of course that
     * _it_ could be found.)
     *
     * @param $decorator_name the name of the decorator to fetch.
     * @return the decorator, or NULL if it was not found and no default was found either.
     */
    function get_decorator($decorator_name = NULL)
    {
        // Ensure the name provided is valid enough to use.
        if ($decorator_name != NULL && $decorator_name != '' && preg_match("/^\w+$/", $decorator_name) == 1)
        {
            $decorator_filename = $this->get_path($decorator_name . '.php');

            // Fall out to use the default if the file couldn't be found.
            if (file_exists($decorator_filename))
            {
                return new Decorator($decorator_filename);
            }
        }

        // Now try the default...
        $decorator_filename = $this->get_path($this->_default_decorator_name . '.php');
        if (file_exists($decorator_filename))
        {
            return new Decorator($decorator_filename);
        }

        // No luck.
        return NULL;
    }
}

?>
