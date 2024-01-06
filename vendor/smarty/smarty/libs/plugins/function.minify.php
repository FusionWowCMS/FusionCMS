<?php

# Import required classes
use MX\CI;
use MatthiasMullie\Minify;

/**
 * Minify
 *
 * @param  array  $params
 */
function smarty_function_minify($params = false)
{
    // Missing a parameter or two..
    if(!is_array($params) || !isset($params['type']) || !isset($params['files']) || !isset($params['output']) || !isset($params['disable']))
        return false;

    // Define ROOTURL
    if(!defined('ROOTURL'))
        define('ROOTURL', rtrim(base_url(str_replace(['\\', DIRECTORY_SEPARATOR], '/', APPPATH)), '/') . '/');

    // Define ROOTPATH
    if(!defined('ROOTPATH'))
        define('ROOTPATH', rtrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, realpath(APPPATH)), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

    // Get parameters
    $type    = strtolower($params['type']);
    $files   = $params['files'];
    $output  = $params['output'];
    $disable = $params['disable'];
    $age = 60 * 60 * 24 * CI::$APP->config->item('minify_cache_time');

    ####################################################################

    # Validate type.Starts

    if(!in_array($type, ['css', 'js']))
        return false;

    # Validate type.Ends

    ####################################################################

    # Validate files.Starts

    if(!$files)
        return false;

    // Increase compatibility
    if(!is_array($files))
        $files = [$files];

    // Format files array
    foreach($files as $k => $file)
    {
        // File is url - no need to go any further
        if(filter_var($files[$k], FILTER_VALIDATE_URL) !== false)
            continue;

        // CSS import - no need to go any further
        if(__minify_parse__($files[$k]))
            continue;

        // Add ROOTPATH to file.. if needed
        if(strpos($files[$k], ROOTPATH) === false)
            $files[$k] = ROOTPATH . str_replace(basename(ROOTPATH), '', $files[$k]);

        // File exists - no need to go any further
        if(file_exists($files[$k]))
            continue;

        // File doesn't exists
        unset($files[$k]);
    }

    # Validate files.Ends

    ####################################################################

    # Validate output.Starts

    if(!$output || strpos($output, $type) === false)
        return false;

    # Validate output.Ends

    ####################################################################

    # Validate disable.Starts

    $disable = ($disable) ? true : false;

    # Validate disable.Ends

    ####################################################################

    // No files left to minify
    if(!count($files))
        return false;

    // Initialize http queries
    $queries = false;

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
    if(strpos($outputPATH, ROOTPATH) === false)
        $outputPATH = ROOTPATH . str_replace(basename(ROOTPATH), '', $outputPATH);

    // Create output directory
    if(!file_exists($outputPATH))
    {
        mkdir($outputPATH);
        chmod($outputPATH, 0755);
    }

    // Initialize valid
    $valid = true;

    // Extra conditions here to check if cache file still valid...
    if(file_exists($outputPATH . $outputFILE)) {
        $cache_time = filemtime($outputPATH . $outputFILE);

        if (time() > $cache_time + $age)
            $valid = false;

        // Minified file found - no need to go any further
        if($valid)
            return __minify_print__($type, [$outputPATH . $outputFILE], $queries);
    }

    // Create new object off `Minify`
    $minifier = ($type === 'css') ? new Minify\CSS() : new Minify\JS();

    // Loop through files and add them to minifier
    foreach($files as $file)
        $minifier->add((filter_var($file, FILTER_VALIDATE_URL) !== FALSE) ? file_get_contents($file) : $file);

    // Save minified file
    $minifier->minify($outputPATH . $outputFILE);

    // Print minified file
    return __minify_print__($type, [$outputPATH . $outputFILE], $queries);
}

/**
 * Minify print
 *
 * @param  string $type
 * @param  array  $files
 * @param  string $queries
 * @return string $output
 */
function __minify_print__($type, $files, $queries = false)
{
    // Initialize output
    $output = '';

    // Prepare tags
    $tags = [
        'js'         => '<script type="text/javascript" src="__file____query__"></script>',
        'css'        => '<link type="text/css" rel="stylesheet" href="__file____query__" />',
        'css_inline' => '<style type="text/css">__file__</style>'
    ];

    // Loop through files
    foreach($files as $file)
    {
        // Backup type
        $_type = $type;

        // CSS import - switch type
        if(__minify_parse__($file))
            $_type = 'css_inline';

        // Swap ROOTPATH with ROOTURL
        $file = str_replace(ROOTPATH, ROOTURL, $file);

        // Append to output
        $output .= str_replace(['__file__', '__query__'], [$file, $queries], $tags[$_type]) . "\n";
    }

    return $output;
}

/**
 * Minify parse
 *
 * @param  string $text
 * @return array  $matches
 */
function __minify_parse__($text)
{
    // Parse @import rules
    preg_match_all("/@import (url\(\"?)?(url\()?(\")?(.*?)(?(1)\")+(?(2)\))+(?(3)\")/i", $text, $matches);

    // No match found
    if(!isset($matches[0][0]))
        return false;

    return $matches;
}
