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

class PrettyJSON
{
    private string|false $json;

    /**
     * Initialize the processing
     *
     * @param Mixed $raw
     */
    public function __construct(mixed $raw)
    {
        $this->json = json_encode($raw);

        $this->main();
    }

    /**
     * Add new lines
     */
    private function main(): void
    {
        // Add new line to { }
        $this->json = preg_replace("/\{/", "\n{\n", $this->json);
        $this->json = preg_replace("/^\n{/", "{", $this->json);
        $this->json = preg_replace("/\}/", "\n}", $this->json);

        // Add new line to [ ]
        $this->json = preg_replace("/\]/", "\n]\n", $this->json);
        $this->json = preg_replace("/\[/", "\n[\n", $this->json);

        // Add new line to all value ends (,)
        $this->json = preg_replace("/,/", ",\n", $this->json);

        // Add indentation
        $this->indent();
    }

    /**
     * Loop through all lines and add indentation
     */
    private function indent(): void
    {
        $lines = explode("\n", $this->json);

        $indent = 0;

        foreach ($lines as $key => $line) {
            $lines[$key] = $this->getIndent($indent) . $line;

            switch ($line) {
                case "[":
                case "{":
                    $indent++;
                    break;

                case "}":
                case "],":
                case "]":
                case "},":
                    $indent--;
                    $lines[$key] = $this->getIndent($indent) . $line;
                    break;

            }
        }

        $this->json = implode("\n", $lines);
    }

    private function getIndent($count): string
    {
        if (!$count) {
            return "";
        }

        return str_repeat("	", $count);
    }

    /**
     * Get the prettified JSON
     *
     * @return String
     */
    public function get(): string
    {
        return $this->json;
    }
}
