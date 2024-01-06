<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Output Class
 *
 * Responsible for sending final output to the browser.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Output
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/userguide3/libraries/output.html
 */
class CI_Output {

	/**
	 * Final output string
	 *
	 * @var	string
	 */
	public string $final_output = '';

	/**
	 * Cache expiration time
	 *
	 * @var	int
	 */
	public int $cache_expiration = 0;

	/**
	 * List of server headers
	 *
	 * @var	array
	 */
	public array $headers = [];

	/**
	 * List of mime types
	 *
	 * @var	array
	 */
	public array $mimes = [];

	/**
	 * Mime-type for the current page
	 *
	 * @var	string
	 */
	protected string $mime_type = 'text/html';

	/**
	 * php.ini zlib.output_compression flag
	 *
	 * @var	bool
	 */
	protected bool $_zlib_oc = false;

	/**
	 * CI output compression flag
	 *
	 * @var	bool
	 */
	protected bool $_compress_output = false;

	/**
	 * List of profiler sections
	 *
	 * @var	array
	 */
	protected array $_profiler_sections =	[];

	/**
	 * Parse markers flag
	 *
	 * Whether or not to parse variables like {elapsed_time} and {memory_usage}.
	 *
	 * @var	bool
	 */
	public bool $parse_exec_vars = true;

	/**
	 * mbstring.func_overload flag
	 *
	 * @var	bool
	 */
	protected static bool $func_overload;

	/**
	 * Class constructor
	 *
	 * Determines whether zLib output compression will be used.
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->_zlib_oc = (bool) ini_get('zlib.output_compression');
		$this->_compress_output = (
			$this->_zlib_oc === false
			&& config_item('compress_output') === true
			&& extension_loaded('zlib')
		);

		isset(self::$func_overload) OR self::$func_overload = (! is_php('8.0') && extension_loaded('mbstring') && @ini_get('mbstring.func_overload'));

		// Get mime types for later
		$this->mimes =& get_mimes();

		log_message('info', 'Output Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get Output
	 *
	 * Returns the current output string.
	 *
	 * @return	string
	 */
	public function get_output(): string
    {
		return $this->final_output;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Output
	 *
	 * Sets the output string.
	 *
	 * @param string $output	Output data
	 * @return	CI_Output
	 */
	public function set_output(string $output): static
    {
		$this->final_output = $output;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Append Output
	 *
	 * Appends data onto the output string.
	 *
	 * @param string $output	Data to append
	 * @return	CI_Output
	 */
	public function append_output(string $output): static
    {
		$this->final_output .= $output;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Header
	 *
	 * Lets you set a server header which will be sent with the final output.
	 *
	 * Note: If a file is cached, headers will not be sent.
	 * @param string $header		Header
	 * @param	bool	$replace	Whether to replace the old header value, if already set
     * @return	CI_Output
	 *@todo	We need to figure out how to permit headers to be cached.
	 *
	 */
	public function set_header(string $header, bool $replace = true): static
    {
		// If zlib.output_compression is enabled it will compress the output,
		// but it will not modify the content-length header to compensate for
		// the reduction, causing the browser to hang waiting for more data.
		// We'll just skip content-length in those cases.
		if ($this->_zlib_oc && strncasecmp($header, 'content-length', 14) === 0)
		{
			return $this;
		}

		$this->headers[] = array($header, $replace);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Content-Type Header
	 *
	 * @param array|string $mime_type	Extension of the file we're outputting
	 * @param string|null $charset	Character set (default: NULL)
	 * @return	CI_Output
	 */
	public function set_content_type(array|string $mime_type, string $charset = null): static
    {
		if (!str_contains($mime_type, '/'))
		{
			$extension = ltrim($mime_type, '.');

			// Is this extension supported?
			if (isset($this->mimes[$extension]))
			{
				$mime_type =& $this->mimes[$extension];

				if (is_array($mime_type))
				{
					$mime_type = current($mime_type);
				}
			}
		}

		$this->mime_type = $mime_type;

		if (empty($charset))
		{
			$charset = config_item('charset');
		}

		$header = 'Content-Type: '.$mime_type
			.(empty($charset) ? '' : '; charset='.$charset);

		$this->headers[] = array($header, true);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Current Content-Type Header
	 *
	 * @return	string	'text/html', if not already set
	 */
	public function get_content_type(): string
    {
		for ($i = 0, $c = count($this->headers); $i < $c; $i++)
		{
			if (sscanf($this->headers[$i][0], 'Content-Type: %[^;]', $content_type) === 1)
			{
				return $content_type;
			}
		}

		return 'text/html';
	}

	// --------------------------------------------------------------------

    /**
     * Get Header
     *
     * @param string $header
     * @return string|null
     */
	public function get_header(string $header): ?string
    {
		// We only need [x][0] from our multidimensional array
		$header_lines = array_map(function ($headers)
		{
			return array_shift($headers);
		}, $this->headers);

		$headers = array_merge(
			$header_lines,
			headers_list()
		);

		if (empty($headers) OR empty($header))
		{
			return null;
		}

		// Count backwards, in order to get the last matching header
		for ($c = count($headers) - 1; $c > -1; $c--)
		{
			if (strncasecmp($header, $headers[$c], $l = self::strlen($header)) === 0)
			{
				return trim(self::substr($headers[$c], $l+1));
			}
		}

		return null;
	}

	// --------------------------------------------------------------------

	/**
	 * Set HTTP Status Header
	 *
	 * As of version 1.7.2, this is an alias for common function
	 * set_status_header().
	 *
	 * @param int $code	Status code (default: 200)
	 * @param string $text	Optional message
	 * @return CI_Output
	 */
	public function set_status_header(int $code = 200, string $text = ''): static
    {
		set_status_header($code, $text);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Profiler Sections
	 *
	 * Allows override of default/config settings for
	 * Profiler section display.
	 *
	 * @param array $sections	Profiler sections
	 * @return	CI_Output
	 */
	public function set_profiler_sections(array $sections): static
    {
		if (isset($sections['query_toggle_count']))
		{
			$this->_profiler_sections['query_toggle_count'] = (int) $sections['query_toggle_count'];
			unset($sections['query_toggle_count']);
		}

		foreach ($sections as $section => $enable)
		{
			$this->_profiler_sections[$section] = ($enable !== false);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cache
	 *
	 * @param int $time	Cache expiration time in minutes
	 * @return	CI_Output
	 */
	public function cache(int $time): static
    {
		$this->cache_expiration = is_numeric($time) ? $time : 0;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Display Output
	 *
	 * Processes and sends finalized output data to the browser along
	 * with any server headers and profile data. It also stops benchmark
	 * timers so the page rendering speed and memory usage can be shown.
	 *
	 * Note: All "view" data is automatically put into $this->final_output
	 *	 by controller class.
	 *
	 * @param	string	$output	Output data override
	 * @return	void
	 *@uses	CI_Output::$final_output
	 */
	public function _display(string $output = ''): void
    {
		// Note:  We use load_class() because we can't use $CI =& get_instance()
		// since this function is sometimes called by the caching mechanism,
		// which happens before the CI super object is available.
		$CFG =& load_class('Config', 'core');

		// Grab the super object if we can.
		if (class_exists('Controller', false))
		{
			$CI =& get_instance();
		}

		// --------------------------------------------------------------------

		// Set the output data
		if ($output === '')
		{
			$output =& $this->final_output;
		}

		// --------------------------------------------------------------------

		// Do we need to write a cache file? Only if the controller does not have its
		// own _output() method and we are not dealing with a cache file, which we
		// can determine by the existence of the $CI object above
		if ($this->cache_expiration > 0 && isset($CI) && ! method_exists($CI, '_output'))
		{
			$this->_write_cache($output);
		}

		// --------------------------------------------------------------------

		// Is compression requested?
		if (isset($CI) // This means that we're not serving a cache file, if we were, it would already be compressed
			&& $this->_compress_output === true
			&& isset($_SERVER['HTTP_ACCEPT_ENCODING']) && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
		{
			ob_start('ob_gzhandler');
		}

		// --------------------------------------------------------------------

		// Are there any server headers to send?
		if (count($this->headers) > 0)
		{
			foreach ($this->headers as $header)
			{
				@header($header[0], $header[1]);
			}
		}

		// --------------------------------------------------------------------

		// Does the $CI object exist?
		// If not we know we are dealing with a cache file so we'll
		// simply echo out the data and exit.
		if (! isset($CI))
		{
			if ($this->_compress_output === true)
			{
				if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
				{
					header('Content-Encoding: gzip');
					header('Content-Length: '.self::strlen($output));
				}
				else
				{
					// User agent doesn't support gzip compression,
					// so we'll have to decompress our cache
					$output = gzinflate(self::substr($output, 10, -8));
				}
			}

			echo $output;
			log_message('info', 'Final output sent to browser');
			return;
		}

		// --------------------------------------------------------------------

		// Does the controller contain a function named _output()?
		// If so send the output there.  Otherwise, echo it.
		if (method_exists($CI, '_output'))
		{
			$CI->_output($output);
		}
		else
		{
			echo $output; // Send it to the browser!
		}

		log_message('info', 'Final output sent to browser');
	}

	// --------------------------------------------------------------------

	/**
	 * Write Cache
	 *
	 * @param string $output	Output data to cache
	 * @return	void
	 */
	public function _write_cache(string $output): void
    {
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');
		$cache_path = ($path === '') ? APPPATH.'cache/' : $path;

		if (! is_dir($cache_path) OR ! is_really_writable($cache_path))
		{
			log_message('error', 'Unable to write cache file: '.$cache_path);
			return;
		}

		$uri = $CI->config->item('base_url')
			.$CI->config->item('index_page')
			.$CI->uri->uri_string();

		if (($cache_query_string = $CI->config->item('cache_query_string')) && ! empty($_SERVER['QUERY_STRING']))
		{
			if (is_array($cache_query_string))
			{
				$uri .= '?'.http_build_query(array_intersect_key($_GET, array_flip($cache_query_string)));
			}
			else
			{
				$uri .= '?'.$_SERVER['QUERY_STRING'];
			}
		}

		$cache_path .= md5($uri);

		if ( ! $fp = @fopen($cache_path, 'w+b'))
		{
			log_message('error', 'Unable to write cache file: '.$cache_path);
			return;
		}

		if ( ! flock($fp, LOCK_EX))
		{
			log_message('error', 'Unable to secure a file lock for file at: '.$cache_path);
			fclose($fp);
			return;
		}

		// If output compression is enabled, compress the cache
		// itself, so that we don't have to do that each time
		// we're serving it
		if ($this->_compress_output === true)
		{
			$output = gzencode($output);

			if ($this->get_header('content-type') === null)
			{
				$this->set_content_type($this->mime_type);
			}
		}

		$expire = time() + ($this->cache_expiration * 60);

		// Put together our serialized info.
		$cache_info = serialize([
			'expire'	=> $expire,
			'headers'	=> $this->headers
		]);

		$output = $cache_info.'ENDCI--->'.$output;

		for ($written = 0, $length = self::strlen($output); $written < $length; $written += $result)
		{
			if (($result = fwrite($fp, self::substr($output, $written))) === false)
			{
				break;
			}
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		if (! is_int($result))
		{
			@unlink($cache_path);
			log_message('error', 'Unable to write the complete cache content at: '.$cache_path);
			return;
		}

		chmod($cache_path, 0640);
		log_message('debug', 'Cache file written: '.$cache_path);

		// Send HTTP cache-control headers to the browser to match file cache settings.
		$this->set_cache_header($_SERVER['REQUEST_TIME'], $expire);
	}

	// --------------------------------------------------------------------

	/**
	 * Update/serve cached output
	 *
	 * @param object    &$CFG	CI_Config class instance
	 * @param	object	&$URI	CI_URI class instance
	 * @return    bool	TRUE on success or FALSE on failure
	 *@uses	CI_URI
	 *
	 * @uses	CI_Config
	 */
	public function _display_cache(object &$CFG, object &$URI): bool
    {
		$cache_path = ($CFG->item('cache_path') === '') ? APPPATH.'cache/' : $CFG->item('cache_path');

		// Build the file path. The file name is an MD5 hash of the full URI
		$uri = $CFG->item('base_url').$CFG->item('index_page').$URI->uri_string;

		if (($cache_query_string = $CFG->item('cache_query_string')) && ! empty($_SERVER['QUERY_STRING']))
		{
			if (is_array($cache_query_string))
				$uri .= '?'.http_build_query(array_intersect_key($_GET, array_flip($cache_query_string)));
			else
				$uri .= '?'.$_SERVER['QUERY_STRING'];
		}

		$filepath = $cache_path.md5($uri);

		if ( ! file_exists($filepath) OR ! $fp = @fopen($filepath, 'rb'))
			return false;

		flock($fp, LOCK_SH);

		$cache = (filesize($filepath) > 0) ? fread($fp, filesize($filepath)) : '';

		flock($fp, LOCK_UN);
		fclose($fp);

		// Look for embedded serialized file info.
		if ( ! preg_match('/^(.*)ENDCI--->/', $cache, $match))
			return false;

		$cache_info = unserialize($match[1]);
		$expire = $cache_info['expire'];

		$last_modified = filemtime($filepath);

		// Has the file expired?
		if ($_SERVER['REQUEST_TIME'] >= $expire && is_really_writable($cache_path))
		{
			// If so we'll delete it.
			@unlink($filepath);
			log_message('debug', 'Cache file has expired. File deleted.');
			return false;
		}

		// Send the HTTP cache control headers
		$this->set_cache_header($last_modified, $expire);

		// Add headers from cache file.
		foreach ($cache_info['headers'] as $header)
		{
			$this->set_header($header[0], $header[1]);
		}

		// Display the cache
		$this->_display(self::substr($cache, self::strlen($match[0])));
		log_message('debug', 'Cache file is current. Sending it to browser.');
		return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete cache
	 *
	 * @param string $uri	URI string
	 * @return	bool
	 */
	public function delete_cache(string $uri = ''): bool
    {
		$CI =& get_instance();
		$cache_path = $CI->config->item('cache_path');
		if ($cache_path === '')
		{
			$cache_path = APPPATH.'cache/';
		}

		if (! is_dir($cache_path))
		{
			log_message('error', 'Unable to find cache path: '.$cache_path);
			return false;
		}

		if (empty($uri))
		{
			$uri = $CI->uri->uri_string();

			if (($cache_query_string = $CI->config->item('cache_query_string')) && ! empty($_SERVER['QUERY_STRING']))
			{
				if (is_array($cache_query_string))
				{
					$uri .= '?'.http_build_query(array_intersect_key($_GET, array_flip($cache_query_string)));
				}
				else
				{
					$uri .= '?'.$_SERVER['QUERY_STRING'];
				}
			}
		}

		$cache_path .= md5($CI->config->item('base_url').$CI->config->item('index_page').ltrim($uri, '/'));

		if (! @unlink($cache_path))
		{
			log_message('error', 'Unable to delete cache file for '.$uri);
			return false;
		}

		return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cache Header
	 *
	 * Set the HTTP headers to match the server-side file cache settings
	 * in order to reduce bandwidth.
	 *
	 * @param int $last_modified	Timestamp of when the page was last modified
	 * @param int $expiration	Timestamp of when should the requested page expire from cache
	 * @return	void
	 */
	public function set_cache_header(int $last_modified, int $expiration): void
    {
		$max_age = $expiration - $_SERVER['REQUEST_TIME'];

		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $last_modified <= strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		{
			$this->set_status_header(304);
			exit;
		}

		header('Pragma: public');
		header('Cache-Control: max-age='.$max_age.', public');
		header('Expires: '.gmdate('D, d M Y H:i:s', $expiration).' GMT');
		header('Last-modified: '.gmdate('D, d M Y H:i:s', $last_modified).' GMT');
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe strlen()
	 *
	 * @param string $str
	 * @return	int
	 */
	protected static function strlen(string $str): int
    {
		return (self::$func_overload)
			? mb_strlen($str, '8bit')
			: strlen($str);
	}

	// --------------------------------------------------------------------

	/**
	 * Byte-safe substr()
	 *
	 * @param string $str
	 * @param int $start
	 * @param int|null $length
	 * @return	string
	 */
	protected static function substr(string $str, int $start, int $length = null): string
    {
		if (self::$func_overload)
		{
			// mb_substr($str, $start, null, '8bit') returns an empty
			// string on PHP 5.3
			isset($length) OR $length = ($start >= 0 ? self::strlen($str) - $start : -$start);
			return mb_substr($str, $start, $length, '8bit');
		}

		return isset($length)
			? substr($str, $start, $length)
			: substr($str, $start);
	}
}
