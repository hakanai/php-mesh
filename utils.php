<?php
/*
    PHP-Mesh - A page meshing framework for PHP.
    Copyright ? 2004  Trejkaz

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

    /**
     * Finds the nearest copy of a given filename by searching in the current path,
     * then the parent path, and so on up to the document root.
     *
     * On non-Apache systems, only searches the current path and the document root.
     *
     * @param $filename the filename to search for.
     * @return the full path to the nearest file with the given filename, or NULL if none was found.
     */
    function find_nearest($filename)
    {
        // This is where we start, at the directory the current script is in.
        $path_url = chop_file($_SERVER['SCRIPT_URL']);
        
        if (function_exists('apache_lookup_uri'))
        {
            while ($path_url != "")
            {
                // Use Apache to find out where the actual file is for that URL.
                $config_info = apache_lookup_uri($path_url . $filename);

                if (file_exists($config_info->filename))
                {
                    // Success!
                    return $config_info->filename;
                }

                $path_url = chop_last($path_url);
            }
        }
        else
        {
            // Fallback for poor souls who aren't on Apache.
            $file = $path_url . $filename;
            if (file_exists($file))
            {
                return $file;
            }
            $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $filename;
            if (file_exists($file))
            {
                return $file;
            }
        }

        // Failure.
        return NULL;
    }

    /**
     * Chops the final component off a path.  Differs from the built-in dirname() function because
     * this doesn't require the path to be an actual file.
     *
     * @param $path the original path.
     * @return the path with one less path component from the end.
     */
    function chop_last($path)
    {
        // Having a trailing slash at the end defeats the purpose of finding the last one.
        $path = rtrim($path, "/");

        // For some lame reason, strrchr in PHP returns the string instead of the offset.
        $tail = strrchr($path, "/");
        return substr($path, 0, strlen($path) - strlen($tail) + 1);
    }

    /**
     * Chops the final component off a path, but only if the final component is a file.  If the
     * path ends in "/", it remains unaffected.
     *
     * @param $path the original path.
     * @return the path with one less path component from the end, if the path didn't end in "/".
     */
    function chop_file($path)
    {
        if (strrchr($path, "/") == "/")
        {
            return $path;
        }
        else
        {
            return chop_last($path);
        }
    }
?>
