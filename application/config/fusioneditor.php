<?php

/**
 * @package FusionCMS
 * @version 6.0
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

$config['fusioneditor'] = array(

    'bold' => array(
            'enabled' => true,
            'text' => "Bold",
            'icon' => "text_bold",
            'compile' => array(
                    'regex_search' => "/<b>(.*?)?<\/b>/i",
                    'regex_replace' => "[b]$1[/b]"
                ),
            'parse' => array(
                    'regex_search' => "/\[b\](.*?)?\[\/b\]/i",
                    'regex_replace' => "<b>$1</b>"
                ),
        ),

    'italic' => array(
            'enabled' => true,
            'text' => "Italic",
            'icon' => "text_italic",
            'compile' => array(
                    'regex_search' => "/<i>(.*?)?<\/i>/i",
                    'regex_replace' => "[i]$1[/i]"
                ),
            'parse' => array(
                    'regex_search' => "/\[i\](.*?)?\[\/i\]/i",
                    'regex_replace' => "<i>$1</i>"
                ),
        ),

    'underline' => array(
            'enabled' => true,
            'text' => "Underline",
            'icon' => "text_underline",
            'compile' => array(
                    'regex_search' => "/<u>(.*?)?<\/u>/i",
                    'regex_replace' => "[u]$1[/u]"
                ),
            'parse' => array(
                    'regex_search' => "/\[u\](.*?)?\[\/u\]/i",
                    'regex_replace' => "<u>$1</u>"
                ),
        ),

    'size' => array(
            'enabled' => true,
            'text' => "Change text size",
            'icon' => "font",
            'compile' => array(
                    'regex_search' => "/<span style=[\"']font-size: ?([0-9]*)px;?[\"']>(.*?)?<\/span>/i",
                    'regex_replace' => "[size=$1]$2[/size]"
                ),
            'parse' => array(
                    'regex_search' => "/\[size=([0-9]*)\](.*?)?\[\/size\]/i",
                    'regex_replace' => "<span style='font-size:$1px'>$2</span>"
                ),
        ),

    'image' => array(
            'enabled' => true,
            'text' => "Insert image",
            'icon' => "picture",
            'compile' => array(
                    'regex_search' => "/<img src=[\"'](http:\/\/[A-Za-z0-9-_.+~: \/]*)[\"'] ?\/?>/",
                    'regex_replace' => "[img]$1[/img]"
                ),
            'parse' => array(
                    'regex_search' => "/\[img\](.*)\[\/img\]/",
                    'regex_replace' => "<img src='$1' />"
                ),
        ),

    'color' => array(
            'enabled' => true,
            'text' => "Change color",
            'icon' => "color_wheel",
            'compile' => array(
                    'regex_search' => "/<span style=[\"']color: ?#(([a-fA-F0-9]){3,6});?[\"']>(.*?)?<\/span>/i",
                    'regex_replace' => "[color=#$1]$3[/color]"
                ),
            'parse' => array(
                    'regex_search' => "/\[color=#(([a-fA-F0-9]){3,6})\](.*?)?\[\/color\]/i",
                    'regex_replace' => "<span style='color:#$1'>$3</span>"
                ),
        ),

    'link' => array(
            'enabled' => true,
            'text' => "Insert link",
            'icon' => "link",
            'compile' => array(
                    'regex_search' => "/<a href=[\"'](http:\/\/[A-Za-z0-9-_.+~: \/]*)[\"']>(.*?)?<\/a>/i",
                    'regex_replace' => "[link=$1]$2[/link]"
                ),
            'parse' => array(
                    'regex_search' => "/\[link=(http:\/\/[A-Za-z0-9-_.+~: \/]*)\](.*?)?\[\/link\]/i",
                    'regex_replace' => "<a href='$1' target='_blank'>$2</a>"
                ),
        ),

    'left' => array(
            'enabled' => true,
            'text' => "Align left",
            'icon' => "text_align_left",
            'compile' => array(
                    'regex_search' => "/<div style=[\"']text-align: ?left;?[\"']>(.*?)?<\/div>/i",
                    'regex_replace' => "[left]$1[/left]"
                ),
            'parse' => array(
                    'regex_search' => "/\[left\](.*?)?\[\/left\]/i",
                    'regex_replace' => "<div style='text-align:left;'>$1</div>"
                ),
        ),

    'center' => array(
            'enabled' => true,
            'text' => "Align center",
            'icon' => "text_align_center",
            'compile' => array(
                    'regex_search' => "/<div style=[\"']text-align: ?center;?[\"']>(.*?)?<\/div>/i",
                    'regex_replace' => "[center]$1[/center]"
                ),
            'parse' => array(
                    'regex_search' => "/\[center\](.*?)?\[\/center\]/i",
                    'regex_replace' => "<div style='text-align:center;'>$1</div>"
                ),
        ),

    'right' => array(
            'enabled' => true,
            'text' => "Align right",
            'icon' => "text_align_right",
            'compile' => array(
                    'regex_search' => "/<div style=[\"']text-align: ?right;?[\"']>(.*?)?<\/div>/i",
                    'regex_replace' => "[right]$1[/right]"
                ),
            'parse' => array(
                    'regex_search' => "/\[right\](.*?)?\[\/right\]/i",
                    'regex_replace' => "<div style='text-align:right;'>$1</div>"
                ),
        ),

    'html' => array(
            'enabled' => true,
            'text' => "Edit HTML source",
            'icon' => "tag",
            'compile' => array(
                    'regex_search' => "",
                    'regex_replace' => ""
                ),
            'parse' => array(
                    'regex_search' => "",
                    'regex_replace' => ""
                ),
        ),

    'tidy' => array(
            'enabled' => true,
            'text' => "Reset all styles",
            'icon' => "cross",
            'compile' => array(
                    'regex_search' => "",
                    'regex_replace' => ""
                ),
            'parse' => array(
                    'regex_search' => "",
                    'regex_replace' => ""
                ),
        ),
);
