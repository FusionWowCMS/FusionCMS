<?php namespace App\Config;

use CodeIgniter\HTTP\{CLIRequest, CURLRequest, IncomingRequest, Response, URI};
use CodeIgniter\Autoloader\Autoloader;
use CodeIgniter\Debug\Exceptions;
use CodeIgniter\Debug\Iterator;
use CodeIgniter\Debug\Timer;
use CodeIgniter\Debug\Toolbar;
use CodeIgniter\Email\Email;
use CodeIgniter\Format\Format;
use CodeIgniter\Log\Logger;
use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\RouteCollectionInterface;
use CodeIgniter\Router\Router;
use CodeIgniter\Security\Security;
use CodeIgniter\Session\Handlers\Database\MySQLiHandler;
use CodeIgniter\Session\Handlers\DatabaseHandler;
use CodeIgniter\Session\Session;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This is used in place of a Dependency Injection container primarily
 * due to its simplicity, which allows a better long-term maintenance
 * of the applications built on top of CodeIgniter. A bonus side-effect
 * is that IDEs are able to determine what class you are calling
 * whereas with DI Containers there usually isn't a way for them to do this.
 *
 * @see http://blog.ircmaxell.com/2015/11/simple-easy-risk-and-change.html
 * @see http://www.infoq.com/presentations/Simple-Made-Easy
 */
class Services
{
    /**
     * Cache for instance of any services that
     * have been requested as a "shared" instance.
     *
     * @var array
     */
    static protected array $instances = [];

    //--------------------------------------------------------------------

    /**
     * The Autoloader class is the central class that handles our
     * spl_autoload_register method, and helper methods.
     */
    public static function autoloader($getShared = false)
    {
        if (! $getShared)
        {
            return new Autoloader();
        }

        return self::getSharedInstance('autoloader');
    }

    //--------------------------------------------------------------------

    /**
     * The CLI Request class provides for ways to interact with
     * a command line request.
     */
    public static function clirequest($getShared = false)
    {
        if (! $getShared)
        {
            return new CLIRequest(
                new URI()
            );
        }

        return self::getSharedInstance('clirequest');
    }

    //--------------------------------------------------------------------

    /**
     * The CURL Request class acts as a simple HTTP client for interacting
     * with other servers, typically through APIs.
     */
    public static function curlrequest(array $options = [], $response = null, $getShared = false)
    {
        if ($getShared === true)
        {
            return self::getSharedInstance('curlrequest', $options, $response);
        }

        if ( ! is_object($response))
        {
            $response = new Response();
        }

        return new CURLRequest(
            new URI(),
            $response,
            $options
        );
    }

    //--------------------------------------------------------------------

    /**
     * The Email class allows you to send email via mail, sendmail, SMTP.
     *
     * @param array $config
     * @param bool $getShared
     *
     * @return Email|mixed
     */
    public static function email(array $config = [], $getShared = false)
    {
        if ($getShared)
        {
            return self::getSharedInstance('email', $config);
        }

        return new Email($config);
    }

    //--------------------------------------------------------------------

    /**
     * The Exceptions class holds the methods that handle:
     *
     *  - set_exception_handler
     *  - set_error_handler
     *  - register_shutdown_function
     */
    public static function exceptions($getShared = false)
    {
        if (! $getShared)
        {
            return new Exceptions();
        }

        return self::getSharedInstance('exceptions');
    }

    //--------------------------------------------------------------------

    /**
     * The Iterator class provides a simple way of looping over a function
     * and timing the results and memory usage. Used when debugging and
     * optimizing applications.
     */
    public static function iterator($getShared = false)
    {
        if (! $getShared)
        {
            return new Iterator();
        }

        return self::getSharedInstance('iterator');
    }

    /**
     * The Logger class is a PSR-3 compatible Logging class that supports
     * multiple handlers that process the actual logging.
     */
    public static function logger($getShared = true)
    {
        if (! $getShared)
        {
            return new Logger();
        }

        return self::getSharedInstance('logger');
    }

    //--------------------------------------------------------------------

    /**
     * The Renderer class is the class that actually displays a file to the user.
     * The default View class within CodeIgniter is intentionally simple, but this
     * service could easily be replaced by a template engine if the user needed to.
     */
    /*public static function renderer($viewPath = APPPATH.'views/', $getShared = false)
    {
        if (! $getShared)
        {
            return new \CodeIgniter\View\View($viewPath);
        }

        return self::getSharedInstance('renderer');
    }*/

    //--------------------------------------------------------------------

    /**
     * The Request class models an HTTP request.
     */
    public static function request($getShared = false)
    {
        if (! $getShared)
        {
            return new IncomingRequest(
                new URI()
            );
        }

        return self::getSharedInstance('request');
    }

    //--------------------------------------------------------------------

    /**
     * The Response class models an HTTP response.
     */
    public static function response($getShared = false)
    {
        if (! $getShared)
        {
            return new Response();
        }

        return self::getSharedInstance('response');
    }

    //--------------------------------------------------------------------

    /**
     * The Routes service is a class that allows for easily building
     * a collection of routes.
     */
    public static function routes($getShared = false)
    {
        if (! $getShared)
        {
            return new RouteCollection();
        }

        return self::getSharedInstance('routes');
    }

    //--------------------------------------------------------------------

    /**
     * The Router class uses a RouteCollection's array of routes, and determines
     * the correct Controller and Method to execute.
     */
    public static function router(RouteCollectionInterface $routes = null, $getShared = false)
    {
        if ($getShared === true)
        {
            return self::getSharedInstance('router', $routes);
        }

        if (empty($routes))
        {
            $routes = self::routes();
        }

        return new Router($routes);
    }

    //--------------------------------------------------------------------

    /**
     * The Security class provides a few handy tools for keeping the site
     * secure, most notably the CSRF protection tools.
     */
    public static function security($getShared = false)
    {
        if (! $getShared)
        {
            return new Security();
        }

        return self::getSharedInstance('security');
    }

    //--------------------------------------------------------------------

    /**
     * @param bool $getShared
     *
     * @return Session
     */
    public static function session($getShared = true)
    {
        if (! $getShared)
        {
            $config = new \App\Config\Session();

            $logger = self::logger();

            $driverName = $config->driver;

            if ($driverName === DatabaseHandler::class) {
                $driverName = MySQLiHandler::class;
            }

            $driver = new $driverName($config, self::request()->getIPAddress());
            $driver->setLogger($logger);

            $session = new Session($driver, $config);
            $session->setLogger($logger);

            if (session_status() === PHP_SESSION_NONE) {
                // PHP Session emits the headers according to `session.cache_limiter`.
                // See https://www.php.net/manual/en/function.session-cache-limiter.php.
                // The headers are not managed by CI's Response class.
                // So, we remove CI's default Cache-Control header.
                self::response()->removeHeader('Cache-Control');

                $session->start();
            }

            return $session;
        }

        return self::getSharedInstance('session');
    }

    //--------------------------------------------------------------------

    /**
     * The Timer class provides a simple way to Benchmark portions of your
     * application.
     */
    public static function timer($getShared = false)
    {
        if (! $getShared)
        {
            return new Timer();
        }

        return self::getSharedInstance('timer');
    }

    //--------------------------------------------------------------------

    public static function toolbar($getShared = false)
    {
        if (! $getShared)
        {
            return new Toolbar();
        }

        return self::getSharedInstance('toolbar');
    }

    //--------------------------------------------------------------------

    /**
     * The URI class provides a way to model and manipulate URIs.
     */
    public static function uri($uri = null, $getShared = false)
    {
        if (! $getShared)
        {
            return new URI($uri);
        }

        return self::getSharedInstance('uri', $uri);
    }

    //--------------------------------------------------------------------

    /**
     * The Format class is a convenient place to create Formatters.
     *
     * @return Format
     */
    public static function format($config = null, bool $getShared = true)
    {
        if (! $getShared)
        {
            return new Format($config);
        }

        return self::getSharedInstance('format', $config);
    }

    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
    // Utility Methods - DO NOT EDIT
    //--------------------------------------------------------------------

    /**
     * Returns a shared instance of any of the class' services.
     *
     * $key must be a name matching a service.
     *
     * @param string $key
     */
    protected static function getSharedInstance(string $key, ...$params)
    {
        $key = strtolower($key);

        if (! isset(static::$instances[$key])) {
            // Make sure $getShared is false
            $params[] = false;

            static::$instances[$key] = self::$key(...$params);
        }

        return static::$instances[$key];
    }

    //--------------------------------------------------------------------

    /**
     * Provides the ability to perform case-insensitive calling of service
     * names.
     *
     * @param string $name
     * @param array  $arguments
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $name = strtolower($name);

        if (method_exists('App\Config\Services', $name))
        {
            return Services::$name(...$arguments);
        }

        return null;
    }

}
