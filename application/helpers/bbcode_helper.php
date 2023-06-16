<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter BBCode Helpers
*
* @package  CodeIgniter
* @subpackage Helpers
* @category Helpers
* @author  Philip Sturgeon
* @link  http://codeigniter.com/wiki/BBCode_Helper/
*/

// ------------------------------------------------------------------------

/**
* parse_bbcode
*
* Converts BBCode style tags into basic HTML
*
* @access public
* @param string unparsed string
* @param int max image width
* @return string
*/

function parse_bbcode($str = '', $max_images = 0)
{
	// Max image size eh? Better shrink that pic!
	if($max_images > 0):
   		$str_max = "style=\"max-width:".$max_images."px; width: [removed]this.width > ".$max_images." ? ".$max_images.": true);\"";
	else:
		$str_max = "";
	endif;

	$find = array(
	  "'\[b\](.*?)\[/b\]'is",
	  "'\[i\](.*?)\[/i\]'is",
	  "'\[u\](.*?)\[/u\]'is",
	  "'\[img\](.*?)\[/img\]'i",
	  "'\[url\](.*?)\[/url\]'i",
	  "'\[url=(.*?)\](.*?)\[/url\]'i",
	  "'\[link\](.*?)\[/link\]'i",
	  "'\[link=(.*?)\](.*?)\[/link\]'i",
	  "'\[quote\](.*?)\[/quote\]'is"
	);

	$replace = array(
	  "<strong>\\1</strong>",
	  "<em>\\1</em>",
	  "<u>\\1</u>",
	  "<img src=\"\\1\"".$str_max.">",
	  "<a href=\"\\1\" target=\"_blank\">\\1</a>",
	  "<a href=\"\\1\" target=\"_blank\">\\2</a>",
	  "<a href=\"\\1\" target=\"_blank\">\\1</a>",
	  "<a href=\"\\1\" target=\"_blank\">\\2</a>",
	   "<blockquote>\\1</blockquote>"
	);

	return preg_replace($find,$replace,$str);
}

/* End of file bbcode_helper.php */
/* Location: ./application/helpers/open_blog.php */