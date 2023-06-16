<?php

//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

$root = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$main_dir = $root . rtrim(urldecode($_POST['dir']), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$authorized_ext = array_values(json_decode(stripslashes($_POST['ext'])));
$folder_prefix = '';
if (preg_match('`[a-z-]+`', $_POST['folder_prefix'])) {
    $folder_prefix = $_POST['folder_prefix'];
}
if (file_exists($main_dir)) {
    $filedata = scan_recursively($main_dir, $authorized_ext, $folder_prefix);
    echo json_encode($filedata);
} else {
    echo 'cannot open dir ' . $main_dir;
}

function scan_recursively($source_dir, $authorized_ext, $folder_prefix, $directory_depth = 5, $hidden = false)
{
    if ($fp = @opendir($source_dir)) {
        $filedata   = array();
        $new_depth  = $directory_depth - 1;
        $source_dir = rtrim($source_dir, '/') . '/';

        $files = scandir($source_dir);
        natsort($files);
        foreach ($files as $file) {
            // Remove '.', '..', and hidden files [optional]
            if (! trim($file, '.') || (!$hidden && $file[0] == '.')) {
                continue;
            }

            if (($directory_depth < 1 || $new_depth > 0) && @is_dir($source_dir . $file)) {
                $filedata[$folder_prefix . $file] = scan_recursively($source_dir . $file . '/', $authorized_ext, $folder_prefix, $new_depth, $hidden);
            } elseif (is_authorized($file, $authorized_ext)) {
                $filedata[] = array(
                    'ext'  => pathinfo($file, PATHINFO_EXTENSION),
                    'name' => $file,
                    'size' => filesize($source_dir . $file)
                );
            }
        }

        closedir($fp);
        return $filedata;
    }
    echo 'can not open dir';
    return false;
}

function is_authorized($file, $authorized_ext)
{
    $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
    if ($authorized_ext[0] === '.*' || in_array($ext, $authorized_ext)) {
        return true;
    }

    return false;
}
