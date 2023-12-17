<?php
/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/userguide3/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

if (! function_exists('heading'))
{
	/**
	 * Heading
	 *
	 * Generates an HTML heading tag.
	 *
	 * @param	string $data content
	 * @param	int $h heading level
	 * @param	string $attributes
     * @return	string
	 */
	function heading($data = '', $h = '1', $attributes = ''): string
	{
		return '<h'.$h._stringify_attributes($attributes).'>'.$data.'</h'.$h.'>';
	}
}

// ------------------------------------------------------------------------

if (! function_exists('ul')) {
    /**
     * Unordered List
     *
     * Generates an HTML unordered list from an single or
     * multi-dimensional array.
     *
     * @param array|object|string $attributes HTML attributes string, array, object
     */
    function ul(array $list, $attributes = ''): string
    {
        return _list('ul', $list, $attributes);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('ol')) {
    /**
     * Ordered List
     *
     * Generates an HTML ordered list from an single or multi-dimensional array.
     *
     * @param array|object|string $attributes HTML attributes string, array, object
     */
    function ol(array $list, $attributes = ''): string
    {
        return _list('ol', $list, $attributes);
    }
}

// ------------------------------------------------------------------------

if (! function_exists('_list')) {
    /**
     * Generates the list
     *
     * Generates an HTML ordered list from an single or multi-dimensional array.
     *
     * @param array               $list
     * @param array|object|string $attributes string, array, object
     */
    function _list(string $type = 'ul', $list = [], $attributes = '', int $depth = 0): string
    {
        // Set the indentation based on the depth
        $out = str_repeat(' ', $depth)
            // Write the opening list tag
            . '<' . $type . stringify_attributes($attributes) . ">\n";

        // Cycle through the list elements.  If an array is
        // encountered we will recursively call _list()

        foreach ($list as $key => $val) {
            $out .= str_repeat(' ', $depth + 2) . '<li>';

            if (! is_array($val)) {
                $out .= $val;
            } else {
                $out .= $key
                    . "\n"
                    . _list($type, $val, '', $depth + 4)
                    . str_repeat(' ', $depth + 2);
            }

            $out .= "</li>\n";
        }

        // Set the indentation for the closing tag and apply it
        return $out . str_repeat(' ', $depth) . '</' . $type . ">\n";
    }
}

// ------------------------------------------------------------------------

if (! function_exists('img')) {
    /**
     * Image
     *
     * Generates an image element
     *
     * @param array|string        $src        Image source URI, or array of attributes and values
     * @param bool                $indexPage  Whether to treat $src as a routed URI string
     * @param array|object|string $attributes Additional HTML attributes
     */
    function img($src = '', bool $indexPage = false, $attributes = ''): string
    {
        if (! is_array($src)) {
            $src = ['src' => $src];
        }
        if (! isset($src['src'])) {
            $src['src'] = $attributes['src'] ?? '';
        }
        if (! isset($src['alt'])) {
            $src['alt'] = $attributes['alt'] ?? '';
        }

        $img = '<img';

        // Check for a relative URI
        if (! preg_match('#^([a-z]+:)?//#i', $src['src']) && strpos($src['src'], 'data:') !== 0) {
            if ($indexPage === true) {
                $img .= ' src="' . get_instance()->config->site_url($src['src']) . '"';
            } else {
                $img .= ' src="' . get_instance()->config->base_url($src['src']) . '"';
            }

            unset($src['src']);
        }

        // Append any other values
        foreach ($src as $key => $value) {
            $img .= ' ' . $key . '="' . $value . '"';
        }

        // Prevent passing completed values to stringify_attributes
        if (is_array($attributes)) {
            unset($attributes['alt'], $attributes['src']);
        }

        return $img . stringify_attributes($attributes) . ' />';
    }
}

if (! function_exists('img_data')) {
    /**
     * Image (data)
     *
     * Generates a src-ready string from an image using the "data:" protocol
     *
     * @param string      $path Image source path
     * @param string|null $mime MIME type to use, or null to guess
     */
    function img_data(string $path, ?string $mime = null): string
    {
        if (! is_file($path) || ! is_readable($path)) {
            return false;
        }

        // Read in file binary data
        $handle = fopen($path, 'rb');
        $data   = fread($handle, filesize($path));
        fclose($handle);

        // Encode as base64
        $data = base64_encode($data);

        // Figure out the type (Hail Mary to JPEG)
        $mime = 'image/jpg';

        return 'data:' . $mime . ';base64,' . $data;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('doctype'))
{
    /**
     * Doctype
     *
     * Generates a page document type declaration
     *
     * Examples of valid options: html5, xhtml-11, xhtml-strict, xhtml-trans,
     * xhtml-frame, html4-strict, html4-trans, and html4-frame.
     * All values are saved in the doctypes config file.
     *
     * @param string $type The doctype to be generated
     */
    function doctype(string $type = 'html5'): string
	{
		static $doctypes;

		if ( ! is_array($doctypes))
		{
			if (file_exists(APPPATH.'config/doctypes.php'))
			{
				include(APPPATH.'config/doctypes.php');
			}

			if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php'))
			{
				include(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php');
			}

			if (empty($_doctypes) OR ! is_array($_doctypes))
			{
				$doctypes = [];
				return false;
			}

			$doctypes = $_doctypes;
		}

		return $doctypes[$type] ?? false;
	}
}

if (! function_exists('script_tag')) {
    /**
     * Script
     *
     * Generates link to a JS file
     *
     * @param array|string $src       Script source or an array of attributes
     * @param bool         $indexPage Should indexPage be added to the JS path
     */
    function script_tag($src = '', bool $indexPage = false): string
    {
        $CI =& get_instance();

        $cspNonce = csp_script_nonce();
        $cspNonce = $cspNonce ? ' ' . $cspNonce : $cspNonce;
        $script   = '<script' . $cspNonce . ' ';
        if (! is_array($src)) {
            $src = ['src' => $src];
        }

        foreach ($src as $k => $v) {
            if ($k === 'src' && ! preg_match('#^([a-z]+:)?//#i', $v)) {
                if ($indexPage === true) {
                    $script .= 'src="' . $CI->config->site_url($v) . '" ';
                } else {
                    $script .= 'src="' . $CI->config->base_url($v) . '" ';
                }
            } else {
                // for attributes without values, like async or defer, use NULL.
                $script .= $k . (null === $v ? ' ' : '="' . $v . '" ');
            }
        }

        return rtrim($script) . '></script>';
    }
}

// ------------------------------------------------------------------------

if (! function_exists('link_tag')) {
    /**
     * Link
     *
     * Generates link tag
     *
     * @param array<string, bool|string>|string $href      Stylesheet href or an array
     * @param bool                              $indexPage should indexPage be added to the CSS path.
     */
    function link_tag(
        $href = '',
        string $rel = 'stylesheet',
        string $type = 'text/css',
        string $title = '',
        string $media = '',
        bool $indexPage = false,
        string $hreflang = ''
    ): string {
		$CI =& get_instance();
        $attributes = [];
        // extract fields if needed
        if (is_array($href)) {
            $rel       = $href['rel'] ?? $rel;
            $type      = $href['type'] ?? $type;
            $title     = $href['title'] ?? $title;
            $media     = $href['media'] ?? $media;
            $hreflang  = $href['hreflang'] ?? '';
            $indexPage = $href['indexPage'] ?? $indexPage;
            $href      = $href['href'] ?? '';
        }

        if (! preg_match('#^([a-z]+:)?//#i', $href)) {
            $attributes['href'] = $indexPage ? $CI->config->site_url($href) : $CI->config->base_url($href);
        } else {
            $attributes['href'] = $href;
        }

        if ($hreflang !== '') {
            $attributes['hreflang'] = $hreflang;
        }

        $attributes['rel'] = $rel;

        if ($type !== '' && $rel !== 'canonical' && $hreflang === '' && ! ($rel === 'alternate' && $media !== '')) {
            $attributes['type'] = $type;
        }

        if ($media !== '') {
            $attributes['media'] = $media;
        }

        if ($title !== '') {
            $attributes['title'] = $title;
        }

        return '<link' . stringify_attributes($attributes) . '/>';
	}
}

if (! function_exists('video')) {
    /**
     * Video
     *
     * Generates a video element to embed videos. The video element can
     * contain one or more video sources
     *
     * @param array|string $src                Either a source string or an array of sources
     * @param string       $unsupportedMessage The message to display if the media tag is not supported by the browser
     * @param string       $attributes         HTML attributes
     */
    function video($src, string $unsupportedMessage = '', string $attributes = '', array $tracks = [], bool $indexPage = false): string
    {
        if (is_array($src)) {
            return _media('video', $src, $unsupportedMessage, $attributes, $tracks);
        }

        $video = '<video';
        $CI =& get_instance();

        if (_has_protocol($src)) {
            $video .= ' src="' . $src . '"';
        } elseif ($indexPage === true) {
            $video .= ' src="' . $CI->config->site_url($src) . '"';
        } else {
            $video .= ' src="' . $CI->config->base_url($src) . '"';
        }

        if ($attributes !== '') {
            $video .= ' ' . $attributes;
        }

        $video .= ">\n";

        foreach ($tracks as $track) {
            $video .= _space_indent() . $track . "\n";
        }

        if (! empty($unsupportedMessage)) {
            $video .= _space_indent()
                . $unsupportedMessage
                . "\n";
        }

        return $video . "</video>\n";
    }
}

if (! function_exists('audio')) {
    /**
     * Audio
     *
     * Generates an audio element to embed sounds
     *
     * @param array|string $src                Either a source string or an array of sources
     * @param string       $unsupportedMessage The message to display if the media tag is not supported by the browser.
     * @param string       $attributes         HTML attributes
     */
    function audio($src, string $unsupportedMessage = '', string $attributes = '', array $tracks = [], bool $indexPage = false): string
    {
        if (is_array($src)) {
            return _media('audio', $src, $unsupportedMessage, $attributes, $tracks);
        }

        $audio = '<audio';
        $CI =& get_instance();

        if (_has_protocol($src)) {
            $audio .= ' src="' . $src . '"';
        } elseif ($indexPage === true) {
            $audio .= ' src="' . $CI->config->site_url($src) . '"';
        } else {
            $audio .= ' src="' . $CI->config->base_url($src) . '"';
        }

        if ($attributes !== '') {
            $audio .= ' ' . $attributes;
        }

        $audio .= '>';

        foreach ($tracks as $track) {
            $audio .= "\n" . _space_indent() . $track;
        }

        if (! empty($unsupportedMessage)) {
            $audio .= "\n" . _space_indent() . $unsupportedMessage . "\n";
        }

        return $audio . "</audio>\n";
    }
}

if (! function_exists('_media')) {
    /**
     * Generate media based tag
     *
     * @param string $unsupportedMessage The message to display if the media tag is not supported by the browser.
     */
    function _media(string $name, array $types = [], string $unsupportedMessage = '', string $attributes = '', array $tracks = []): string
    {
        $media = '<' . $name;

        if (empty($attributes)) {
            $media .= '>';
        } else {
            $media .= ' ' . $attributes . '>';
        }

        $media .= "\n";

        foreach ($types as $option) {
            $media .= _space_indent() . $option . "\n";
        }

        foreach ($tracks as $track) {
            $media .= _space_indent() . $track . "\n";
        }

        if (! empty($unsupportedMessage)) {
            $media .= _space_indent() . $unsupportedMessage . "\n";
        }

        return $media . ('</' . $name . ">\n");
    }
}

if (! function_exists('source')) {
    /**
     * Source
     *
     * Generates a source element that specifies multiple media resources
     * for either audio or video element
     *
     * @param string $src        The path of the media resource
     * @param string $type       The MIME-type of the resource with optional codecs parameters
     * @param string $attributes HTML attributes
     */
    function source(string $src, string $type = 'unknown', string $attributes = '', bool $indexPage = false): string
    {
        $CI =& get_instance();
        if (! _has_protocol($src)) {
            $src = $indexPage === true ? $CI->config->site_url($src) : $CI->config->base_url($src);
        }

        $source = '<source src="' . $src
            . '" type="' . $type . '"';

        if (! empty($attributes)) {
            $source .= ' ' . $attributes;
        }

        return $source . '/>';
    }
}

if (! function_exists('meta'))
{
	/**
	 * Generates meta tags from an array of key/values
	 *
	 * @param	array $name
     * @param	string $content
     * @param	string $type
     * @param	string $newline
     * @return	string
	 */
	function meta($name = '', $content = '', $type = 'name', $newline = "\n"): string
	{
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($name))
		{
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		elseif (isset($name['name']))
		{
			// Turn single array into multidimensional
			$name = array($name);
		}

		$str = '';
		foreach ($name as $meta)
		{
			$type		= (isset($meta['type']) && $meta['type'] !== 'name')	? 'http-equiv' : 'name';
			$name		= $meta['name'] ?? '';
			$content	= $meta['content'] ?? '';
			$newline	= $meta['newline'] ?? "\n";

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}

if (! function_exists('track')) {
    /**
     * Track
     *
     * Generates a track element to specify timed tracks. The tracks are
     * formatted in WebVTT format.
     *
     * @param string $src The path of the .VTT file
     */
    function track(string $src, string $kind, string $srcLanguage, string $label): string
    {
        return '<track src="' . $src
            . '" kind="' . $kind
            . '" srclang="' . $srcLanguage
            . '" label="' . $label
            . '"/>';
    }
}

if (! function_exists('object')) {
    /**
     * Object
     *
     * Generates an object element that represents the media
     * as either image or a resource plugin such as audio, video,
     * Java applets, ActiveX, PDF and Flash
     *
     * @param string $data       A resource URL
     * @param string $type       Content-type of the resource
     * @param string $attributes HTML attributes
     */
    function object(string $data, string $type = 'unknown', string $attributes = '', array $params = [], bool $indexPage = false): string
    {
        $CI =& get_instance();
        if (! _has_protocol($data)) {
            $data = $indexPage === true ? $CI->config->site_url($data) : $CI->config->base_url($data);
        }

        $object = '<object data="' . $data . '" '
            . $attributes . '>';

        if (! empty($params)) {
            $object .= "\n";
        }

        foreach ($params as $param) {
            $object .= _space_indent() . $param . "\n";
        }

        return $object . "</object>\n";
    }
}

if (! function_exists('param')) {
    /**
     * Param
     *
     * Generates a param element that defines parameters
     * for the object element.
     *
     * @param string $name       The name of the parameter
     * @param string $value      The value of the parameter
     * @param string $type       The MIME-type
     * @param string $attributes HTML attributes
     */
    function param(string $name, string $value, string $type = 'ref', string $attributes = ''): string
    {
        return '<param name="' . $name
            . '" type="' . $type
            . '" value="' . $value
            . '" ' . $attributes . '/>';
    }
}

if (! function_exists('embed')) {
    /**
     * Embed
     *
     * Generates an embed element
     *
     * @param string $src        The path of the resource to embed
     * @param string $type       MIME-type
     * @param string $attributes HTML attributes
     */
    function embed(string $src, string $type = 'unknown', string $attributes = '', bool $indexPage = false): string
    {
        $CI =& get_instance();
        if (! _has_protocol($src)) {
            $src = $indexPage === true ? $CI->config->site_url($src) : $CI->config->base_url($src);
        }

        return '<embed src="' . $src
            . '" type="' . $type . '" '
            . $attributes . "/>\n";
    }
}

if (! function_exists('_has_protocol')) {
    /**
     * Test the protocol of a URI.
     *
     * @return false|int
     */
    function _has_protocol(string $url)
    {
        return preg_match('#^([a-z]+:)?//#i', $url);
    }
}

if (! function_exists('_space_indent')) {
    /**
     * Provide space indenting.
     */
    function _space_indent(int $depth = 2): string
    {
        return str_repeat(' ', $depth);
    }
}
