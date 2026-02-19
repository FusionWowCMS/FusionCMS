<?php

class ConfigEditor
{
    private string $file;
    private string $data;

    /**
     * Initialize the config editor and load the file
     *
     * @param String $file
     */
    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException("Config file not found: $file");
        }

        $this->file = $file;
        $this->data = file_get_contents($file);
    }

    /**
     * Change a config value
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set(mixed $key, mixed $value): void
    {
        $value = $this->formatValue($value);

        // Check for sub array replacement
        if (str_contains($key, '-')) {
            [$mainKey, $subKey] = explode('-', $key, 2);
            $this->updateNestedKey($mainKey, $subKey, $value);
        } else {
            $this->updateFlatKey($key, $value);
        }
    }

    /**
     * Save the edited config file
     */
    public function save(): void
    {
        file_put_contents($this->file, $this->data);
    }

    /**
     * Get the edited config content
     *
     * @return string
     */
    public function get(): string
    {
        return $this->data;
    }

    /**
     * Convert different types of values to strings compatible with PHP config syntax
     *
     * @param mixed $value
     * @return string
     */
    private function formatValue(mixed $value): string
    {
        if (is_string($value)) {
            $lower = strtolower($value);
            if ($lower === 'true') {
                $value = true;
            } elseif ($lower === 'false') {
                $value = false;
            }
        }

        if (empty($value) && !is_numeric($value) && !is_bool($value)) {
            return 'false';
        }

        return match (true) {
            is_array($value) => $this->formatArray($value),
            is_bool($value) => $value ? 'true' : 'false',
            is_float($value) => rtrim(rtrim(number_format($value, 8, '.', ''), '0'), '.'),
            is_int($value) => (string)$value,
            is_numeric($value) => (string)$value,
            is_string($value) => "'" . str_replace("'", "\\'", $value) . "'",
            default => 'NULL',
        };
    }

    /**
     * Format array as PHP-style [...] string
     *
     * @param array $array
     * @return string
     */
    private function formatArray(array $array): string
    {
        $formatted = [];

        foreach ($array as $key => $val) {
            $keyStr = is_int($key) ? '' : $this->formatValue($key) . ' => ';
            $formatted[] = $keyStr . $this->formatValue($val);
        }

        return '[' . implode(', ', $formatted) . ']';
    }


    /**
     * Update or insert a top-level config key
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    private function updateFlatKey(string $key, string $value): void
    {
        $pattern = '/\$config\[(["\'])?' . preg_quote($key, '/') . '\1?\]\s*=\s*[^;]+;/';
        $replacement = "\$config['$key'] = $value;";

        if (preg_match($pattern, $this->data)) {
            $this->data = preg_replace($pattern, $replacement, $this->data);
        } else {
            $this->data .= PHP_EOL . $replacement;
        }
    }


    /**
     * Update or insert a nested key inside an array config (e.g. $config['array'] = [...])
     *
     * @param string $mainKey
     * @param string $subKey
     * @param string $newValue
     * @return void
     */
    private function updateNestedKey(string $mainKey, string $subKey, string $newValue): void
    {
        $pattern = '/\$config\[(["\'])?' . preg_quote($mainKey, '/') . '\1?\]\s*=\s*(array\s*\((.*?)\)|\[(.*?)\]);/s';

        if (preg_match($pattern, $this->data, $matches)) {

            // if array(...)
            if (!empty($matches[3])) {
                $arrayBody = $matches[3];
            }
            // if [ ... ]
            else {
                $arrayBody = $matches[4];
            }

            $subPattern = '/[\'"]' . preg_quote($subKey, '/') . '[\'"]\s*=>\s*[^,]+/';
            if (preg_match($subPattern, $arrayBody)) {
                $arrayBody = preg_replace($subPattern, "'$subKey' => $newValue", $arrayBody);
            } else {
                $arrayBody = trim($arrayBody);
                if (!empty($arrayBody)) {
                    $arrayBody .= ", ";
                }
                $arrayBody .= "'$subKey' => $newValue";
            }

            // always store output as short array
            $replacement = "\$config['$mainKey'] = [$arrayBody];";

            $this->data = preg_replace($pattern, $replacement, $this->data);
        } else {
            // If there is no main key, create a new array
            $newArray = "\$config['$mainKey'] = ['$subKey' => $newValue];";
            $this->data .= PHP_EOL . $newArray;
        }
    }
}
