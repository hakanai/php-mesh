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

    /**
     * Resolves a path relative to a given base path, taking possible absolute
     * paths into account.
     *
     * If $path is absolute, it is returned as-is.
     * If $path is relative, it is treated as a relative path with respect to $basepath,
     * and the resulting path is returned.
     *
     * In both cases, the path returned, will have had the realpath() function applied.
     *
     * @param $basepath the base path, must be absolute.
     * @param $path the path, relative or absolute.
     * @return $path if it was absolute, otherwise the result of $path relative to $basepath.
     */
    function resolve_path($basepath, $path)
    {
        $basepath = str_replace("\\", "/", $basepath);
        $path = str_replace("\\", "/", $path);
        
        if (is_absolute($path))
        {
            return realpath($path);
        }
        else
        {
            return realpath($basepath . '/' . $path);
        }
    }

    /**
     * Tests whether a pathname is absolute.
     *
     * @param $path the path.
     * @return TRUE if the path was absolute, FALSE otherwise.
     */
    function is_absolute($path)
    {
        $regex = (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') ? "/^([a-z][A-Z]:)?[\/\\]/" : "/^\//";

        return (boolean) preg_match($regex, $path);
    }

?>
