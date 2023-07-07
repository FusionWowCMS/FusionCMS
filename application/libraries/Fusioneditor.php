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

class FusionEditor
{
    private $CI;
    private $tools;

    /**
     * Load the CodeIgniter instance and define the tools
     */
    public function __construct()
    {
        $this->CI = &get_instance();

        // Full set of tools
        $this->CI->load->config('fusioneditor');
        $this->tools = $this->CI->config->item('fusioneditor');
    }

    /**
     * Create a new editor
     *
     * @param  Int $id Editor selector
     * @param  Array $disabled_tools
     * @param  Int $height
     * @param  String $content
     * @return String
     */
    public function create($id, $disabled_tools = false, $height = 250, $content = "")
    {
        $tools = $this->getTools($disabled_tools);

        // Gather the values
        $data = array(
                    'id' => $id,
                    'tools' => $tools,
                    'url' => $this->CI->template->page_url,
                    'height' => $height,
                    'content' => $content
                );

        // Load the editor
        $output = $this->CI->smarty->view($this->CI->template->view_path . "fusioneditor.tpl", $data, true);

        return $output;
    }

    /**
     * Compile HTML into BBcode
     *
     * @param  String $content
     * @param  Array $disabled_tools
     * @return String
     */
    public function compile($content, $disabled_tools = false)
    {
        $tools = $this->getTools($disabled_tools);

        // Convert each tool output into bbcode
        foreach ($tools as $tool) {
            if (!empty($tool['compile']['regex_search']) && !empty($tool['compile']['regex_replace']) && $tool['enabled']) {
                $content = preg_replace($tool['compile']['regex_search'], $tool['compile']['regex_replace'], $content);
            }
        }

        // Preserve the line breaks
        $content = preg_replace("/<br ?\/?>/i", "\n", $content);

        // Make sure the rest isn't displayed as HTML
        $content = $this->CI->security->xss_clean($content);

        // Convert space into actual space
        $content = preg_replace("/&amp;nbsp;/", " ", $content);

        return $content;
    }

    /**
     * Parse BBcode as HTML
     *
     * @param  String $content
     * @param  Array $disabled_tools
     * @return String
     */
    public function parse($content, $disabled_tools = false)
    {
        $tools = $this->getTools($disabled_tools);

        // Convert each tool output into bbcode
        foreach ($tools as $tool) {
            if (!empty($tool['parse']['regex_search']) && !empty($tool['parse']['regex_replace']) && $tool['enabled']) {
                $content = preg_replace($tool['parse']['regex_search'], $tool['parse']['regex_replace'], $content);
            }
        }

        // Re-create the line breaks
        $content = nl2br($content);

        // Convert space into actual HTML space
        $content = preg_replace("/  /", "&nbsp;&nbsp;", $content);

        return $content;
    }

    /**
     * Disable tools
     *
     * @param  Array $disabled_tools
     * @return Array
     */
    private function getTools($disabled_tools)
    {
        // Copy a full set of the tools
        $tools = $this->tools;

        // If there are tools to disable
        if (
            $disabled_tools != false
            && is_array($disabled_tools)
        ) {
            foreach ($disabled_tools as $tool) {
                // Disable if it exists
                if (array_key_exists($tool, $tools)) {
                    $tools[$tool]['enabled'] = false;
                }
            }
        }

        return $tools;
    }
}
