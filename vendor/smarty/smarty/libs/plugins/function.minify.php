<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty minify function plugin
 *
 * Type:    function<br>
 * Name:    minify<br>
 * Date:    2023-07-09
 * Purpose: minify content from several JS or CSS files into one
 * Input:   string to count
 * Example: {minify input=$array_of_files_to_minify output=$path_to_output_file age=$seconds_to_try_reminify_file}
 *
 * @author Keramat Jokar
 * @version 1.0
 * @param array
 * @param string
 * @param int
 * @return string
 */
 
use MatthiasMullie\Minify;

function smarty_function_minify($params, &$smarty)
{
    /**
     * Build minified file
     *
     * @param array $params
     */
    if (!function_exists('smarty_build_minify')) {
        function smarty_build_minify($params)
        {
            $filelist = array();
            $lastest_mtime = time();

            $filelist = $params['input'];
            $output_filename = preg_replace('/\.(js|css)$/i', '.$1', $params['output']);

            $last_cmtime = 0;

            if (file_exists($params['file_path'] . $output_filename)) {
                $last_cmtime = filemtime($params['file_path'] . $output_filename);
            }

            if ($lastest_mtime > $last_cmtime) {
                $files_to_cleanup = glob($params['file_path'] . $output_filename);

                foreach ($files_to_cleanup as $cfile) {
                    if (is_file($cfile) && file_exists($cfile)) {
                        unlink($cfile);
                    }
                }

                $dirname = dirname($params['file_path'] . $output_filename);

                if (!is_dir($dirname)) {
                    mkdir($dirname, 0755, true);
                }

                $min = null;
                if ($params['type'] == 'js') {
                    $min = new Minify\JS();
                } elseif ($params['type'] == 'css') {
                    $min = new Minify\CSS();
                }

                foreach ($filelist as $file) {
                    if (filter_var($file, FILTER_VALIDATE_URL) !== FALSE)
                        $min->add(file_get_contents($file));
                    else
                        $min->add((filter_var($params['file_path'] . $file, FILTER_VALIDATE_URL) !== FALSE) ? file_get_contents($params['file_path'] . $file) : $params['file_path'] . $file);
                }

				$min->minify($params['file_path'] . $output_filename);
            }

            smarty_print_out($params);
        }
    }

    /**
     * Print filename
     *
     * @param string $params
     */
    if ( ! function_exists('smarty_print_out')) {
        function smarty_print_out($params)
        {
            if ($params['disable'] == true) {
                $output = '';
                $filelist = $params['input'];
                foreach ($filelist as $file) {
                    if ($params['type'] == 'js') {
                        $output .= '<script type="text/javascript" src="' . base_url() . $file.'" charset="utf-8"></script>' . "\n";
                    } elseif ($params['type'] == 'css') {
                        $output .= '<link type="text/css" rel="stylesheet" href="' . base_url() . $file . '" />' . "\n";
                    }
                }

                echo $output;
            } else {
                $last_mtime = 0;
                $output_filename = preg_replace('/\.(js|css)$/i', '.$1', $params['output']);
			    $url = base_url() . APPPATH;

                if (file_exists($params['file_path'] . $output_filename)) {
                    $last_mtime = filemtime($params['file_path'] . $output_filename);
                }

                if ($params['type'] == 'js') {
                    echo '<script type="text/javascript" src="' . $url .  $output_filename . '" charset="utf-8"></script>';
                } elseif ($params['type'] == 'css') {
                    echo '<link type="text/css" rel="stylesheet" href="' . $url .  $output_filename . '" />';
                } else {
                    echo $output_filename;
                }
            }
        }
    }

    $params['file_path'] = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, realpath(APPPATH). '/');

    if (!isset($params['input'])) {
        trigger_error('input cannot be empty', E_USER_NOTICE);
        return;
    }

    if (!is_array($params['input']) || count($params['input']) < 1) {
        trigger_error('input must be array and have one item at least', E_USER_NOTICE);
        return;
    }

    foreach ($params['input'] as $file) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if (!in_array($ext, array('js', 'css'))) {
            trigger_error('all input files must have js or css extension', E_USER_NOTICE);
            return;
        }

        $files_extensions[] = $ext;
    }

    if (count(array_unique($files_extensions)) > 1) {
        trigger_error('all input files must have the same extension', E_USER_NOTICE);
        return;
    }

    $params['type'] = $ext;

    if (!isset($params['output'])) {
        trigger_error('output cannot be empty', E_USER_NOTICE);
    }

    if (!isset($params['age'])) {
        $params['age'] = 60 * 60 * 24 * CI::$APP->config->item('minify_cache_time');
    }

    if (!isset($params['disable'])) {
        $params['disable'] = false;
    }

    if ($params['disable'] == true) {
        smarty_print_out($params);
        return;
    }

    $output_filename = preg_replace('/\.(js|css)$/i', '.$1', $params['output']);
    $cache_time = filemtime($params['file_path'] . $output_filename);

    if (time() > $cache_time + $params['age']) {
        smarty_build_minify($params);
    } else {
        smarty_print_out($params);
    }
}
