<?php

# Import required classes
use MX\CI;
use Config\Services;
use MatthiasMullie\Minify;

/**
 * Minify
 *
 * @param array $params
 * @return void|string
 */
function smarty_tag_minify(array $params = [])
{
    // Missing a parameter or two..
    if(!is_array($params) || !isset($params['type']) || !isset($params['files']) || !isset($params['output']) || !isset($params['disable']))
        return;

    ####################################################################

    # Define constants.Starts

    // Define: Directory separator shortcut
    if(!defined('MIN_DS'))
        define('MIN_DS', DIRECTORY_SEPARATOR);

    // Define: ROOTURL
    if(!defined('MIN_ROOTURL'))
        define('MIN_ROOTURL', rtrim(base_url(str_replace(['\\', MIN_DS, basename(APPPATH)], ['/', '/', ''], basename(APPPATH))), '/') . '/');

    // Define: ROOTPATH
    if(!defined('MIN_ROOTPATH'))
        define('MIN_ROOTPATH', rtrim(str_replace(['\\', '/', basename(APPPATH)], [MIN_DS, MIN_DS, ''], realpath(APPPATH)), MIN_DS) . MIN_DS);

    # Define constants.Ends

    ####################################################################

    # Gather parameters.Starts

    $type    = strtolower($params['type']);
    $files   = $params['files'];
    $output  = $params['output'];
    $disable = $params['disable'];

    # Gather parameters.Ends

    ####################################################################

    # Validate type.Starts

    if(!in_array($type, ['css', 'js']))
        return;

    # Validate type.Ends

    ####################################################################

    # Validate files.Starts

    if(!$files)
        return;

    // Increase compatibility
    if(!is_array($files))
        $files = [$files];

    // Format files array
    foreach($files as $k => $file)
    {
        // File is url - no need to go any further
        if(filter_var($files[$k], FILTER_VALIDATE_URL) !== FALSE)
            continue;

        // CSS import - no need to go any further
        if(__minify_hasImport__($files[$k]))
            continue;

        // Add ROOTPATH to file.. if needed
        if(strpos($files[$k], MIN_ROOTPATH) === false)
            $files[$k] = MIN_ROOTPATH . str_replace(basename(MIN_ROOTPATH), '', $files[$k]);

        // File exists - no need to go any further
        if(file_exists($files[$k]))
            continue;

        // File doesn't exists
        unset($files[$k]);
    }

    # Validate files.Ends

    ####################################################################

    # Validate output.Starts

    if(!$output || strpos($output, '.' . $type) === false)
        return;

    # Validate output.Ends

    ####################################################################

    # Validate disable.Starts

    $disable = ($disable) ? true : false;

    # Validate disable.Ends

    ####################################################################

    // No files left to minify
    if(!count($files))
        return;

    // Initialize http queries
    $queries = '';

    // Get http queries from output
    if(parse_url($output, PHP_URL_QUERY))
    {
        $queries = '?' . parse_url($output, PHP_URL_QUERY);
        $output  = str_replace($queries, '', $output);
    }

    // Minifier is disabled, print all files
    if($disable)
        return __minify_print__($type, $files, $queries);

    // Split file name from output path
    $outputFILE = basename($output);
    $outputPATH = str_replace($outputFILE, '', $output);

    // Add ROOTPATH to output.. if needed
    if(strpos($outputPATH, MIN_ROOTPATH) === false)
        $outputPATH = MIN_ROOTPATH . str_replace(basename(MIN_ROOTPATH), '', $outputPATH);

    // Create output directory
    if(!file_exists($outputPATH))
    {
        mkdir($outputPATH, 0755, true);
        chmod($outputPATH, 0755);
    }

    // Extra conditions here to check if cache file still alive...
    if(file_exists($outputPATH . $outputFILE))
    {
        // Calculate age
        $age = filemtime($outputPATH . $outputFILE) + (60 * 60 * 24 * CI::$APP->config->item('minify_cache_time'));

        // Initialize alive
        $alive = true;

        // Saved file is passed away..
        if(time() > $age)
            $alive = false;

        // Minified file found - no need to go any further
        if($alive)
            return __minify_print__($type, [$outputPATH . $outputFILE], $queries);
    }

    // Create new object off `Minify`
    $minifier = ($type === 'css') ? new Minify\CSS() : new Minify\JS();

    // Loop through files and add them to minifier
    foreach($files as $file)
        $minifier->add((filter_var($file, FILTER_VALIDATE_URL) !== FALSE) ? Services::curlrequest()->get($file)->getBody() : $file);

    // Save minified file
    $minifier->minify($outputPATH . $outputFILE);

    // Print minified file
    return __minify_print__($type, [$outputPATH . $outputFILE], $queries);
}

/**
 * Minify print
 * Returns formatted html tags
 *
 * @param string $type
 * @param array $files
 * @param string $queries
 * @return string $output
 */
function __minify_print__(string $type = '', array $files = [], string $queries = '')
{
    // Initialize output
    $output = '';

    // Prepare tags
    $tags = [
        'js'         => '<script type="text/javascript" src="__file____query__"></script>',
        'css'        => '<link type="text/css" rel="stylesheet" href="__file____query__" />',
        'css_inline' => '<style type="text/css">__file__</style>'
    ];

    // Backup type
    $_type = $type;

    // Loop through files
    foreach($files as $file)
    {
        // Restore type
        $type = $_type;

        // CSS import - switch type
        if(__minify_hasImport__($file))
            $type = 'css_inline';

        // Swap ROOTPATH with ROOTURL
        $file = str_replace(MIN_ROOTPATH, MIN_ROOTURL, $file);

        // Append to output
        $output .= str_replace(['__file__', '__query__'], [$file, $queries], $tags[$type]) . PHP_EOL;
    }

    return $output;
}

/**
 * Minify has import
 * Checks for css @import rules
 *
 * @param string $text
 * @return bool
 */
function __minify_hasImport__(string $text = '')
{
    // Parse @import rules
    preg_match_all("/@import (url\(\"?)?(url\()?(\")?(.*?)(?(1)\")+(?(2)\))+(?(3)\")/i", $text, $matches);

    // No match found
    if(!isset($matches[0][0]))
        return false;

    return true;
}
