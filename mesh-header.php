<?php
    //--------------------------------------------------------------------------------------------------------
    // Mesh Header
    //
    // This page is intended to be an automatically-included header.
    //
    // Author: Trejkaz Xaoza <trejkaz@xaoza.net>
    //--------------------------------------------------------------------------------------------------------

    // Include user configuration from the base web directory.
    // Redundant right now because we don't use any configuration here.
    //require_once("${DOCUMENT_ROOT}/.phpmeshrc");

    // Bunch of crap to disable caching.
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");                // Date in the past
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   // always modified
    header("Cache-Control: no-store, no-cache, must-revalidate");    // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");                                      // HTTP/1.0

    // Now we have to scrape the useful stuff out of the page...
    $matches = array();

    // Use output buffering to read the page into a string.
    ob_start();

    // The real page will occur next because this file is the header.
?>

