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
class Mesh
{
    // The page title.
    var $title;

    // The remainder of the page head contents, after the title is removed.
    var $headRemains;

    // The meta variables.
    var $metas = array();

    // The page body.
    var $body;

    // The body attributes.
    var $bodyAttrs = array();

    /**
     * Constructs a Mesh object.
     *
     * @param $pageContent The entire page content, as a single string.
     */
    function Mesh($pageContent)
    {
        // Match the <head/> element.
        if (preg_match("#<head.*?>(.*?)</head>#s", $pageContent, $matches))
        {
            $pageHead = $matches[1];

            // Match the <title/> element.
            if (preg_match("#<title.*?>(.*?)</title>#s", $pageHead, $matches))
            {
                // Store away the title.
                $this->title = trim($matches[1]);

                // Store away the header with the title removed.
                $this->headRemains = trim(preg_replace("#<title>(.*?)</title>#s", "", $pageHead));
                if ($this->headRemains != "")
                {
                    $this->headRemains .= "\n";
                }

                // Match <meta/> tags.
                if (preg_match("#<meta.*?>#", $pageHead, $matches))
                {
                    $pageMetaTag = $matches[0];

                    // Match the key.  (name and http-equiv are treated equally.)
                    if (preg_match("#\bname\s*=\s*\"(.*?)\"#s", $pageMetaTag, $matches) ||
                        preg_match("#\bhttp-equiv\s*=\s*\"(.*?)\"#s", $pageMetaTag, $matches))
                    {
                        $pageMetaName = $matches[1];
                    }

                    // Match the value.
                    if (preg_match("#\bcontent\s*=\s*\"(.*?)\"#s", $pageMetaTag, $matches))
                    {
                        $pageMetaValue = $matches[1];
                    }

                    // Store away the meta key and value.
                    $this->metas[$pageMetaName] = $pageMetaValue;
                }
            }
        }

        // Match the <body/> element.
        if (preg_match("#(<body.*?>)(.*?)</body>#s", $pageContent, $matches))
        {
            // Store away the body.
            $this->body = trim($matches[2]) . "\n";

            // Match the attributes in the body tag.
            $pageBodyStartTag = $matches[1];
            if (preg_match_all("#\b(\S+)\s*=\s*\"(.*?)\"#s", $pageBodyStartTag, $matches, PREG_SET_ORDER))
            {
                foreach ($matches as $match)
                {
                    // Store away the body attribute key and value.
                    $this->bodyAttrs[$match[1]] = $match[2];
                }
            }
        }
    }

    /**
     * Print the page title.
     */
    function printTitle()
    {
        print($this->title);
    }

    /**
     * Print the remainder of the head contents, after the title is removed.
     */
    function printHeadRemains()
    {
        print($this->headRemains);
    }

    /**
     * Print a single meta tag.
     *
     * @param $metaName The name of the meta tag.
     * @param $formatted Whether to format the meta tag as HTML. (default = false) 
     */
    function printMeta($metaName, $formatted = false)
    {
        if ($this->metas[$metaName])
        {
            if ($formatted)
            {
                print("<meta name=\"$metaName\" content=\"");
            }
            print($this->metas[$metaName]);
            if ($formatted)
            {
                print("\" />");
            }
        }
    }

    /**
     * Print a single attribute from the body tag.
     *
     * @param $attrName The name of the attribute.
     * @param $formatted Whether to format the attribute as HTML. (default = false)
     */
    function printBodyAttr($attrName, $formatted = false)
    {
        if ($this->bodyAttrs[$attrName])
        {
            if ($formatted)
            {
                print(" $attrName=\"");
            }
            print($this->bodyAttrs[$attrName]);
            if ($formatted)
            {
                print("\"");
            }
        }
    }

    /**
     * Print the page body.
     */
    function printBody()
    {
        print($this->body);
    }

} // class Mesh

?>
