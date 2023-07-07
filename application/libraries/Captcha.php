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

class Captcha
{
    protected $CI;

    /**
     * Configuration
     */
    private $stack = "abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ123456789";
    private $length = 7;

    /**
     * Runtime values
     */
    private $value;
    private $stackLength;

    /**
     * Initialize the current session if available
     */
    public function __construct($enable = true)
    {
        //Load CI Instance
        $this->CI = &get_instance();

        $this->CI->load->helper('captcha');

        // Count the stack (starting from 0)
        $this->stackLength = strlen($this->stack) - 1;

        if (session_id() == '') {
            session_start();
        }

        // Initialize the previous session
        if (isset($_SESSION['captcha'])) {
            $this->value = $_SESSION['captcha'];
        }

        if (!$enable) {
            $this->value = false;
        }
    }

    /**
     * Generate a new value and tie it to a session
     */
    public function generate()
    {
        $this->value = "";

        for ($i = 0; $i < $this->length; $i++) {
            $this->value .= $this->random();
        }

        $_SESSION['captcha'] = $this->value;
    }

    /**
     * Generate one random character from the stack
     *
     * @return String
     */
    private function random()
    {
        return $this->stack[rand(0, $this->stackLength)];
    }

    private function adjustBrightness($hexCode, $adjustPercent)
    {
        $hexCode = ltrim($hexCode, '#');

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode($hexCode);
    }

    private function getContrastColor($hexColor)
    {
        // hexColor RGB
        $R1 = hexdec(substr($hexColor, 1, 2));
        $G1 = hexdec(substr($hexColor, 3, 2));
        $B1 = hexdec(substr($hexColor, 5, 2));

        // Black RGB
        $blackColor = "#000000";
        $R2BlackColor = hexdec(substr($blackColor, 1, 2));
        $G2BlackColor = hexdec(substr($blackColor, 3, 2));
        $B2BlackColor = hexdec(substr($blackColor, 5, 2));

        // Calc contrast ratio
        $L1 = 0.2126 * pow($R1 / 255, 2.2) +
            0.7152 * pow($G1 / 255, 2.2) +
            0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
                0.7152 * pow($G2BlackColor / 255, 2.2) +
                0.0722 * pow($B2BlackColor / 255, 2.2);

        $contrastRatio = 0;
        if ($L1 > $L2) {
            $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
        } else {
            $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
        }

        // If contrast is more than 5, return black color
        if ($contrastRatio > 10) {
            return $this->adjustBrightness($hexColor, -0.3);
        } elseif ($contrastRatio > 5) {
            return $this->adjustBrightness($hexColor, 0.7);
        } else {
            return $this->adjustBrightness($hexColor, 0.7);
        }
    }

    /**
     * Create an image
     *
     * @param Int $width
     * @param Int $height
     */
    public function output($width = 150, $height = 30)
    {
        $bgcolor = sprintf("#%02x%02x%02x", rand(0, 255), rand(0, 255), rand(0, 255));
        $textcolor = $this->getContrastColor($bgcolor);
        $gridColor = $this->getContrastColor($textcolor);

        $vals = array(
            'word'          => $this->getValue(),
            'img_path'      => FCPATH . '/uploads/captcha/',
            'img_url'       => pageURL . '/uploads/captcha/',

            'img_width'     => $width,
              'img_height'    => $height,

            'font_size'     => 16,
            'font_path'     => APPPATH . 'fonts/Roboto-Regular.ttf',

            'colors'        => array(
                'background' => sscanf($bgcolor, "#%02x%02x%02x"),
                'border' => sscanf($textcolor, "#%02x%02x%02x"),
                'text' => sscanf($textcolor, "#%02x%02x%02x"),
                'grid' => sscanf($gridColor, "#%02x%02x%02x")
            )
        );

        $cap = create_captcha($vals);
        //die(print_r($cap));

        // Define the headers and output it
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-type: image/png");
        $image = imagecreatefromjpeg($vals["img_path"] . $cap["filename"]);
        imagejpeg($image);

        //Delete Captcha after view
        unlink($vals["img_path"] . $cap["filename"]);
        die();
    }

    /**
     * Get the captcha value as plaintext and destroy the session
     *
     * @return String
     */
    public function getValue()
    {
        return $this->value;
    }
}
