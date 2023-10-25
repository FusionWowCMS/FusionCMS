<?php

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class ConfigEditor
{
    private string $file;
    private mixed $data;

    /**
     * Initialize the config editor and load the file
     *
     * @param String $file
     */
    public function __construct(string $file)
    {
        $this->data = "";
        $this->file = $file;

        $handle = fopen($this->file, "r");

        while (!feof($handle)) {
            $this->data .= fgets($handle);
        }

        fclose($handle);
    }

    /**
     * Change a config value
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set(mixed $key, mixed $value): void
    {
        // Create an array
        if (is_array($value)) {
            $value = "array(" . implode(",", $value) . ")";
        }

        // Create a boolean
        elseif (is_bool($value)) {
            $value = ($value) ? "true" : "false";
        }

        // Create a boolean from string
        elseif (in_array($value, array("true", "false"))) {
            $value = $value;
        }

        // Create an integer
        elseif (is_numeric($value)) {
            $value = $value;
        } elseif (empty($value)) {
            $value = "false";
        }

        // Create an array from a string of numbers separated by comma
        elseif (preg_match("/^([0-9]*,? ?)*$/", $value)) {
            $value = "array(" . $value . ")";
        }

        // Create a string
        else {
            $value = "\"" . str_replace('"', '\"', $value) . "\"";
        }

        // Check for sub array replacement
        if (preg_match("/.*-.*/", $key)) {
            $parts = explode("-", $key);

            preg_match('/\$config\[["\']' . $parts[0] . '["\']\] ?= [^;]*/', $this->data, $matches);

            if (count($matches)) {
                $matches[0] = preg_replace('/^\$config\[["\']' . $parts[0] . '["\']\] ?= /', "", $matches[0]);
                $matches[0] = preg_replace('/;$/', "", $matches[0]);

                $key = $parts[0];
                $value = preg_replace('/["\']' . $parts[1] . '["\'] ?=> ?["\']?.*["\']?,?/', "'" . $parts[1] . "' => " . $value . ",", $matches[0]);
            }
        }

        $this->data = preg_replace('/\$config\[["\']' . $key . '["\']\] ?= ?["\']?.*["\']?;/', "\$config['" . $key . "'] = " . $value . ";", $this->data);
    }

    /**
     * Save the edited config file
     */
    public function save(): void
    {
        $file = fopen($this->file, "w");
        fwrite($file, $this->data);
        fclose($file);
    }

    /**
     * Get the edited config content
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->data;
    }
}
