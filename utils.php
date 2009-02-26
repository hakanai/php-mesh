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
        $regex = (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') ? "/^([a-z][A-Z]:)?[\\\/\\\\]/" : "/^\//";

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
        if (function_exists('apache_lookup_uri'))
        {
            if (isset($_SERVER['SCRIPT_NAME']))
            {
                $path_url = chop_file($_SERVER['SCRIPT_NAME']);
            }

            // Some PHPs appeared to have this instead.
            if (isset($_SERVER['SCRIPT_URL']) && !isset($path_url))
            {
                $path_url = chop_file($_SERVER['SCRIPT_URL']);
            }

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
            // If not on Apache we use SCRIPT_FILENAME instead, which is the full
            // path to the script as given to us by PHP.
            if (isset($_SERVER['SCRIPT_FILENAME']))
            {
                $path = chop_file(realpath($_SERVER['SCRIPT_FILENAME']));
            }

            // We can't just stop at DOCUMENT_ROOT as on some systems the script
            // is running from an aliased directory instead of inside the docroot.
            while ($path != "")
            {
                $file = $path . $filename;
                if (file_exists($file))
                {
                    // Success!
                    return $file;
                }

                $path = chop_last($path);
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
        if ($path == "")
        {
            return "";
        }

        // For some lame reason, strrchr in PHP returns the string instead of the offset.
        $tail = strrchr($path, "/");
        return substr($path, 0, strlen($path) - strlen($tail) + 1);
    }

    /**
     * Chops the final component off a path, but only if the final component is a file, which is
     * to say that if the path ends in "/", it remains unaffected.
     *
     * The returned path will include the slash in all cases.
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

    /**
     * Parses the HTTP_ACCEPT_LANGUAGE header and returns a list of languages / locale names
     * in the requesting browser's preferred order.
     *
     * @return a list of languages the browser accepts, with the better ones listed first.
     */
    function parse_http_accept_language()
    {
        $header = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $langs = explode(',', $header);

        $qvalues = array();
        foreach ($langs as $lang)
        {
            ereg('([a-z]{1,2}(-([a-z0-9]+))?)(;q=([0-9\.]+))?', $lang, $found);
            $code = $found[1];
            $qvalue = $found[5] ? $found[5] : 1.0;
            $qvalues[$code] = $qvalue;
        }

        // Maintains the key mappings while reordering based on the values.
        arsort($qvalues);
        return array_keys($qvalues);
    }
?>
