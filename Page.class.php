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

/**
 * This class parses the HTML page which is to be decorated, and provides
 * various convenience methods for getting and printing data from the page.
 *
 * @author Trejkaz Xaoza <trejkaz@xaoza.net>
 */
class Page
{
    // The page title.
    // This variable is prone to change, so don't use it directly.
    var $_title;

    // The remainder of the page head contents, after the title is removed.
    // This variable is prone to change, so don't use it directly.
    var $_head;

    // The page properties.
    // This variable is prone to change, so don't use it directly.
    var $_properties = array();

    // The page body.
    // This variable is prone to change, so don't use it directly.
    var $_body;

    /**
     * Constructs a Page object.
     *
     * @param $page_content The entire page content, as a single string.
     */
    function Page($page_content)
    {
        // Match the <head/> element.
        if (preg_match("#<head.*?>(.*?)</head>#si", $page_content, $matches))
        {
            $this->_head = $matches[1];

            // Match the <title/> element.
            if (preg_match("#<title.*?>(.*?)</title>#si", $this->_head, $matches))
            {
                // Store away the title.
                $this->_title = trim($matches[1]);

                // Match <meta/> tags.
                if (preg_match("#<meta.*?>#i", $this->_head, $matches))
                {
                    $meta_tag = $matches[0];

                    // Match the key.  (name and http-equiv are treated equally.)
                    if (preg_match("#\bname\s*=\s*\"(.*?)\"#si", $meta_tag, $matches) ||
                        preg_match("#\bhttp-equiv\s*=\s*\"(.*?)\"#si", $meta_tag, $matches))
                    {
                        $meta_name = $matches[1];
                    }

                    // Match the value.
                    if (preg_match("#\bcontent\s*=\s*\"(.*?)\"#si", $meta_tag, $matches))
                    {
                        $meta_value = $matches[1];
                    }

                    // Store away the meta key and value.
                    $this->_properties['meta.' . $meta_name] = $meta_value;
                }

                // Store away the header with the title removed.
                $this->_head = preg_replace("#<title.*?>.*?</title>#si", "", $this->_head);
                $this->_head = trim($this->_head);
            }
        }

        // Match the <body/> element.
        if (preg_match("#(<body.*?>)(.*?)</body>#si", $page_content, $matches))
        {
            // Store away the body.
            $this->_body = trim($matches[2]) . "\n";

            // Match the attributes in the body tag.
            $body_start_tag = $matches[1];
            if (preg_match_all("#\b(\S+)\s*=\s*\"(.*?)\"#s", $body_start_tag, $matches, PREG_SET_ORDER))
            {
                foreach ($matches as $match)
                {
                    // Store away the body attribute key and value.
                    $this->_properties['body.' . $match[1]] = $match[2];
                }
            }
        }
    }

    /**
     * Print the page title.
     *
     * @param $default The default value of the title, to use if no property is defined.
     */
    function title()
    {
        print($this->_title);
    }

    /**
     * Print the remainder of the head contents, after the title is removed.
     */
    function head()
    {
        print($this->_head);
    }

    /**
     * Gets the URL of the page which is being viewed.
     *
     * @return the URL of the page which is being viewed.
     */
    function get_url()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get a single property.
     *
     * @param $property_name The name of the property.
     * @param $default The default value of the property, to use if the property is not defined.
     * @return the value of that property, or the default if the property was not defined.
     */
    function get_property($propertyName, $default = NULL)
    {
        $property_value = $this->_properties[$property_name];
        if ($property_value == NULL)
        {
            $property_name = $default;
        }
        return $property_value;
    }

    /**
     * Print a single property.
     *
     * Properties found in <meta> tags are named meta.[propertyName].
     * Properties found on the <body> tag as attributes are named body.[propertyName].
     *
     * @param $property_name The name of the property.
     * @param $default The default value of the property, to use if the property is not defined.
     * @param $formatted Whether to format the property as it originally appeared.
     */
    function property($property_name, $default = NULL, $formatted = false)
    {
        $property_value = $this->get_property($property_name, $default);
        if ($property_value != NULL)
        {
            if ($formatted)
            {
                if (strstr($property_name, "meta.") == 0)
                {
                    print("<meta name=\"$property_name\" content=\"");
                }
                else if (strstr($property_name, "body.") == 0)
                {
                    print(" $property_name=\"");
                }
            }

            print($property_value);

            if ($formatted)
            {
                if (strstr($property_name, "meta.") == 0)
                {
                    print("\" />");
                }
                else if (strstr($property_name, "body.") == 0)
                {
                    print("\"");
                }
            }
        }
    }

    /**
     * Print the page body.
     */
    function body()
    {
        print($this->_body);
    }

    /**
     * Includes the specified page as decorated content.
     *
     * @param $page_location the location of the page to fetch and apply the
      *                      decorator to, which may be relative to the decorator.
     * @param $decorator_name the name of the decorator to decorate the page with.
     */
    function apply_decorator($page_location, $decorator_name)
    {
        global $decorator_selector;

        // Capture the output from requiring the page.
        ob_start();
        require($decorator_selector->get_path($page_location));
        $page_contents = ob_get_clean();

        // Create the page object.  This guy does all the parsing work.
        $page = new Page($page_contents);

        // Create the decorator.
        $decorator = $decorator_selector->get_decorator($decorator_name);

        // Perform the decoration.
        $decorator->decorate($page);
    }

} // class Page

?>
