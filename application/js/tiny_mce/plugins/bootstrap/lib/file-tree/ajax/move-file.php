<?php

$root = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
// var_dump($_POST);
foreach ($_POST as $key => $value) {
    $$key = urldecode(stripslashes($_POST[$key]));
}
$ext = json_decode($ext);
$authorized_ext = array_values($ext);

if (
    !isset($filename) ||
    !isset($filepath) ||
    !isset($destpath) ||
    !isset($filehash) ||
    !preg_match('`[a-z0-9]+`', $filehash) ||
    preg_match('`\.\.|\*`', $filepath) ||
    preg_match('`\.\.|\*`', $destpath)
) {
    exit('1');
}

$salt = '%t$qPP';
if (hash('sha256', $filepath . $salt) !== $filehash) {
    exit('2');
}

$rootfilepath = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $root . $filepath);
$rootdestpath = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $root . $destpath);

if (!file_exists(($rootfilepath))) {
    exit('3');
}
if (!is_authorized($filename, $authorized_ext)) {
    exit('4');
}

// Security checks ok

$out = array();

if (!@copy($rootfilepath, $rootdestpath)) {
    $out = array(
        'status' => 'danger',
        'msg'    => 'Failed to copy ' . $rootdestpath
    );
} else {
    if (file_exists($rootfilepath)) {
        if (!@unlink($rootfilepath)) {
            $out = array(
                'status' => 'danger',
                'msg'    => 'Failed to delete ' . $rootfilepath
            );
        } else {
            $out = array(
                'status' => 'success',
                'msg'    => ''
            );
        }
    } else {
        $out = array(
            'status' => 'danger',
            'msg'    => 'file doesn\'t exist'
        );
    }
}

echo json_encode($out);

function is_authorized($file, $authorized_ext)
{
    $ext = '.' . pathinfo($file, PATHINFO_EXTENSION);
    if ($authorized_ext[0] === '.*' || in_array($ext, $authorized_ext)) {
        return true;
    }

    return false;
}
