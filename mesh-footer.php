<?php
    //--------------------------------------------------------------------------------------------------------
    // Mesh Footer
    //
    // This page is intended to be an automatically-included footer.
    //
    // Author: Trejkaz Xaoza <trejkaz@xaoza.net>
    //--------------------------------------------------------------------------------------------------------

    // Include the page parsing class.
    require_once("Page.class.php");

    // Include user configuration from the root of the web directory.
    require_once("${DOCUMENT_ROOT}/.phpmeshrc");

    // The real page just occurred because this is the footer.
    $pageContent = ob_get_contents();
    ob_end_clean();

    // Create the page object.  This guy does all the parsing work.
    $page = new Page($pageContent);

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

