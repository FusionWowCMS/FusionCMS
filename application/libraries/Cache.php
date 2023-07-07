<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Cache
{
    private $runtimeCache;
    private $enabled;
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->runtimeCache = array();
        $this->enabled = $this->CI->config->item('cache');

        $this->createFolders();
    }

    private function createFolders()
    {
        if (!file_exists("application/cache")) {
            mkdir("application/cache");
            fopen("application/cache/index.html", "w");
        }

        if (!file_exists("application/cache/data")) {
            mkdir("application/cache/data");
            fopen("application/cache/data/index.html", "w");
        }

        if (!file_exists("application/cache/data/items")) {
            mkdir("application/cache/data/items");
            fopen("application/cache/data/items/index.html", "w");
        }

        if (!file_exists("application/cache/data/spells")) {
            mkdir("application/cache/data/spells");
            fopen("application/cache/data/spells/index.html", "w");
        }

        if (!file_exists("application/cache/data/search")) {
            mkdir("application/cache/data/search");
            fopen("application/cache/data/search/index.html", "w");
        }

        if (!file_exists("application/cache/templates")) {
            mkdir("application/cache/templates");
            fopen("application/cache/templates/index.html", "w");
        }
    }

    /**
     * Get cached data by name
     *
     * @param  String $name
     * @param  Boolean $useLanguage
     * @return Mixed
     */
    public function get($name)
    {
        // If cache is turned off
        if (!$this->enabled) {
            return false;
        }

        if (strlen($name) > 100) {
            die('Cache name is too long');
        }

        // Check if file has already been loadaed
        if (array_key_exists($name, $this->runtimeCache)) {
            return $this->runtimeCache[$name];
        } else {
            // Format file name
            $fileName = "application/cache/data/" . $name . ".cache";

            // Cache exists
            if (file_exists($fileName)) {
                // Load the cache
                $content = file_get_contents("application/cache/data/" . $name . ".cache");

                // Decode the JSON data
                $data = json_decode($content, true);

                // Check if the expiration value is set
                if (isset($data['expiration'])) {
                    if ($data['expiration'] > time()) {
                        $this->runtimeCache[$name] = $data['content'];
                        return $data['content'];
                    } else {
                        // Cache expired
                        $this->runtimeCache[$name] = false;
                        return false;
                    }
                } else {
                    // Corrupted cache
                    $this->runtimeCache[$name] = false;
                    return false;
                }
            } else {
                // Cache doesn't exist
                $this->runtimeCache[$name] = false;
                return false;
            }
        }
    }

    /**
     * Cache data
     *
     * @param String $name
     * @param Mixed $data
     * @param Int $expiration In seconds
     */
    public function save($name, $data, $expiration = 31536000)
    {
        // If cache is turned off
        if (!$this->enabled) {
            return false;
        }

        // Prepare the file content
        $cache = array(
                    "expiration" => time() + $expiration,
                    "content" => $data
                );

        // Encode as JSON
        $json = json_encode($cache);

        // Construct the file name
        $fileName = "application/cache/data/" . $name . ".cache";

        // Open the file and write the data
        $file = fopen($fileName, 'w');
        fwrite($file, $json);
        fclose($file);
    }

    /**
     * Delete cache by name (wildcards supported)
     *
     * @param String $name
     */
    public function delete($name)
    {
        $matches = glob("application/cache/data/" . $name);

        if ($matches) {
            foreach ($matches as $file) {
                if (is_dir($file)) {
                    $this->delete(preg_replace("/application\/cache\/data\//", "", $file) . "/*");
                } else {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Delete all cache
     */
    public function deleteAll()
    {
        $this->delete('*');
    }

    /**
     * Check if a cache has expired
     *
     * @param  String $name
     * @param  String $matchRegex
     * @return Boolean
     */
    public function hasExpired($name, $matchRegex = false)
    {
        if (preg_match("/\*/", $name)) {
            $matches = glob("application/cache/data/" . $name);

            if (count($matches) && is_array($matches)) {
                if ($matchRegex) {
                    foreach ($matches as $file) {
                        if (preg_match($matchRegex, $file)) {
                            $name = preg_replace("/application\/cache\/data\/([A-Za-z0-9_-]*)\.cache/", "$1", $file);
                        }
                    }
                } else {
                    $name = preg_replace("/application\/cache\/data\/([A-Za-z0-9_-]*)\.cache/", "$1", $matches[0]);
                }
            } else {
                return true;
            }
        }

        if ($this->get($name) !== false) {
            // Has not expired
            return false;
        } else {
            // Has expired
            return true;
        }
    }
}
