<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\HTTP;

/**
 * Abstraction for an HTTP user agent
 */
class UserAgent
{
    /**
     * Current user-agent
     *
     * @var string
     */
    protected $agent = '';

    /**
     * Flag for if the user-agent belongs to a browser
     *
     * @var bool
     */
    protected $isBrowser = false;

    /**
     * Flag for if the user-agent is a robot
     *
     * @var bool
     */
    protected $isRobot = false;

    /**
     * Flag for if the user-agent is a mobile browser
     *
     * @var bool
     */
    protected $isMobile = false;

    /**
     * Languages accepted by the current user agent
     *
     * @var array
     */
    public array $languages = [];

    /**
     * Character sets accepted by the current user agent
     *
     * @var array
     */
    public array $charsets = [];

    /**
     * List of platforms to compare against current user agent
     *
     * @var array
     */
    public array $platforms = [];

    /**
     * List of browsers to compare against current user agent
     *
     * @var array
     */
    public array $browsers = [];

    /**
     * List of mobile browsers to compare against current user agent
     *
     * @var array
     */
    public array $mobiles = [];

    /**
     * List of robots to compare against current user agent
     *
     * @var array
     */
    public array $robots = [];

    /**
     * Current user-agent platform
     *
     * @var string
     */
    protected $platform = '';

    /**
     * Current user-agent browser
     *
     * @var string
     */
    protected $browser = '';

    /**
     * Current user-agent version
     *
     * @var string
     */
    protected $version = '';

    /**
     * Current user-agent mobile name
     *
     * @var string
     */
    protected $mobile = '';

    /**
     * Current user-agent robot name
     *
     * @var string
     */
    protected $robot = '';

    /**
     * HTTP Referer
     *
     * @var bool|string|null
     */
    protected $referrer;

    /**
     * Constructor
     *
     * Sets the User Agent and runs the compilation routine
     */
    public function __construct()
    {
        $this->load_agent_config();

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->agent = trim($_SERVER['HTTP_USER_AGENT']);
            $this->compileData();
        }
    }

    /**
     * Compile the User Agent Data
     *
     * @return	bool
     */
    protected function load_agent_config()
    {
        if (($found = file_exists(APPPATH.'config/user_agents.php')))
        {
            include(APPPATH.'config/user_agents.php');
        }

        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php');
            $found = true;
        }

        if ($found !== true)
        {
            return false;
        }

        $return = false;

        if (isset($platforms))
        {
            $this->platforms = $platforms;
            unset($platforms);
            $return = true;
        }

        if (isset($browsers))
        {
            $this->browsers = $browsers;
            unset($browsers);
            $return = true;
        }

        if (isset($mobiles))
        {
            $this->mobiles = $mobiles;
            unset($mobiles);
            $return = true;
        }

        if (isset($robots))
        {
            $this->robots = $robots;
            unset($robots);
            $return = true;
        }

        return $return;
    }

    /**
     * Is Browser
     */
    public function isBrowser(?string $key = null): bool
    {
        if (! $this->isBrowser) {
            return false;
        }

        // No need to be specific, it's a browser
        if ($key === null) {
            return true;
        }

        // Check for a specific browser
        return isset($this->browsers[$key]) && $this->browser === $this->browsers[$key];
    }

    /**
     * Is Robot
     */
    public function isRobot(?string $key = null): bool
    {
        if (! $this->isRobot) {
            return false;
        }

        // No need to be specific, it's a robot
        if ($key === null) {
            return true;
        }

        // Check for a specific robot
        return isset($this->robots[$key]) && $this->robot === $this->robots[$key];
    }

    /**
     * Is Mobile
     */
    public function isMobile(?string $key = null): bool
    {
        if (! $this->isMobile) {
            return false;
        }

        // No need to be specific, it's a mobile
        if ($key === null) {
            return true;
        }

        // Check for a specific robot
        return isset($this->mobiles[$key]) && $this->mobile === $this->mobiles[$key];
    }

    /**
     * Is this a referral from another site?
     */
    public function isReferral(): bool
    {
        if (! isset($this->referrer)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $this->referrer = false;
            } else {
                $refererHost = @parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
                $ownHost     = parse_url(\base_url(), PHP_URL_HOST);

                $this->referrer = ($refererHost && $refererHost !== $ownHost);
            }
        }

        return $this->referrer;
    }

    /**
     * Agent String
     */
    public function getAgentString(): string
    {
        return $this->agent;
    }

    /**
     * Get Platform
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * Get Browser Name
     */
    public function getBrowser(): string
    {
        return $this->browser;
    }

    /**
     * Get the Browser Version
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get The Robot Name
     */
    public function getRobot(): string
    {
        return $this->robot;
    }

    /**
     * Get the Mobile Device
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * Get the referrer
     */
    public function getReferrer(): string
    {
        return empty($_SERVER['HTTP_REFERER']) ? '' : trim($_SERVER['HTTP_REFERER']);
    }

    /**
     * Parse a custom user-agent string
     *
     * @return void
     */
    public function parse(string $string)
    {
        // Reset values
        $this->isBrowser = false;
        $this->isRobot   = false;
        $this->isMobile  = false;
        $this->browser   = '';
        $this->version   = '';
        $this->mobile    = '';
        $this->robot     = '';

        // Set the new user-agent string and parse it, unless empty
        $this->agent = $string;

        if ($string !== '') {
            $this->compileData();
        }
    }

    /**
     * Compile the User Agent Data
     *
     * @return void
     */
    protected function compileData()
    {
        $this->setPlatform();

        foreach (['setRobot', 'setBrowser', 'setMobile'] as $function) {
            if ($this->{$function}() === true) {
                break;
            }
        }
    }

    /**
     * Set the Platform
     */
    protected function setPlatform(): bool
    {
        if ($this->platforms) {
            foreach ($this->platforms as $key => $val) {
                if (preg_match('|' . preg_quote($key, '|') . '|i', $this->agent)) {
                    $this->platform = $val;

                    return true;
                }
            }
        }

        $this->platform = 'Unknown Platform';

        return false;
    }

    /**
     * Set the Browser
     */
    protected function setBrowser(): bool
    {
        if ($this->browsers) {
            foreach ($this->browsers as $key => $val) {
                if (preg_match('|' . $key . '.*?([0-9\.]+)|i', $this->agent, $match)) {
                    $this->isBrowser = true;
                    $this->version   = $match[1];
                    $this->browser   = $val;
                    $this->setMobile();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set the Robot
     */
    protected function setRobot(): bool
    {
        if ($this->robots) {
            foreach ($this->robots as $key => $val) {
                if (preg_match('|' . preg_quote($key, '|') . '|i', $this->agent)) {
                    $this->isRobot = true;
                    $this->robot   = $val;
                    $this->setMobile();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set the Mobile Device
     */
    protected function setMobile(): bool
    {
        if ($this->mobiles) {
            foreach ($this->mobiles as $key => $val) {
                if (false !== (stripos($this->agent, $key))) {
                    $this->isMobile = true;
                    $this->mobile   = $val;

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Outputs the original Agent String when cast as a string.
     */
    public function __toString(): string
    {
        return $this->getAgentString();
    }
}