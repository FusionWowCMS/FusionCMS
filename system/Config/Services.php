<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Config;

use App\Config\Migrations;
use App\Config\Paths;
use CodeIgniter\HTTP\{CLIRequest,
    CURLRequest,
    IncomingRequest,
    Negotiate,
    RequestInterface,
    Response,
    ResponseInterface,
    URI};
use App\Config\Exceptions as ExceptionsConfig;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\MigrationRunner;
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
use CodeIgniter\Config\Format as FormatConfig;
use CodeIgniter\Typography\Typography;
use App\Config\Services as AppServices;
use App\Config\App;
use Config\ContentSecurityPolicy as ContentSecurityPolicyConfig;
use Config\ContentSecurityPolicy as CSPConfig;

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
class Services extends BaseService
{
    /**
     * The CLI Request class provides for ways to interact with
     * a command line request.
     *
     * @return CLIRequest
     *
     * @internal
     */
    public static function clirequest(bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('clirequest');
        }

        return new CLIRequest(new URI());
    }

    /**
     * Content Security Policy
     *
     * @return ContentSecurityPolicy
     */
    public static function csp(?CSPConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('csp', $config);
        }

        $config ??= config(ContentSecurityPolicyConfig::class);

        return new ContentSecurityPolicy($config);
    }

    /**
     * The CURL Request class acts as a simple HTTP client for interacting
     * with other servers, typically through APIs.
     *
     * @return CURLRequest
     */
    public static function curlrequest(array $options = [], ?ResponseInterface $response = null, bool $getShared = false)
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

    /**
     * The Email class allows you to send email via mail, sendmail, SMTP.
     *
     * @param array $config
     * @param bool $getShared
     *
     * @return Email
     */
    public static function email(array $config = [], bool $getShared = true)
    {
        if ($getShared)
        {
            return self::getSharedInstance('email', $config);
        }

        return new Email($config);
    }

    /**
     * The Exceptions class holds the methods that handle:
     *
     *  - set_exception_handler
     *  - set_error_handler
     *  - register_shutdown_function
     *
     * @return Exceptions
     */
    public static function exceptions(?ExceptionsConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('exceptions', $config);
        }

        $config ??= config(ExceptionsConfig::class);

        return new Exceptions($config);
    }

    /**
     * The Format class is a convenient place to create Formatters.
     *
     * @return Format
     */
    public static function format(?FormatConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('format', $config);
        }

        $config ??= config(FormatConfig::class);

        return new Format($config);
    }

    /**
     * The Iterator class provides a simple way of looping over a function
     * and timing the results and memory usage. Used when debugging and
     * optimizing applications.
     *
     * @return Iterator
     */
    public static function iterator(bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('iterator');
        }

        return new Iterator();
    }

    /**
     * The Logger class is a PSR-3 compatible Logging class that supports
     * multiple handlers that process the actual logging.
     *
     * @return Logger
     */
    public static function logger(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('logger');
        }

        return new Logger();
    }

    /**
     * Return the appropriate Migration runner.
     *
     * @return MigrationRunner
     */
    public static function migrations(?Migrations $config = null, ?ConnectionInterface $db = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('migrations', $config, $db);
        }

        $config ??= config(Migrations::class);

        return new MigrationRunner($config, $db);
    }

    /**
     * Returns the current Request object.
     *
     * createRequest() injects IncomingRequest or CLIRequest.
     *
     * @return IncomingRequest
     *
     * @deprecated The parameter $getShared are deprecated.
     */
    public static function request(?App $config = null, bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        // @TODO remove the following code for backward compatibility
        return AppServices::incomingrequest($config, $getShared);
    }

    /**
     * Create the current Request object, either IncomingRequest or CLIRequest.
     *
     * This method is called from CodeIgniter::getRequestObject().
     *
     * @internal
     */
    public static function createRequest(App $config, bool $isCli = false): void
    {
        if ($isCli) {
            $request = AppServices::clirequest();
        } else {
            $request = AppServices::incomingrequest($config);

            // guess at protocol if needed
            $request->setProtocolVersion($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1');
        }

        // Inject the request object into Services.
        static::$instances['request'] = $request;
    }

    /**
     * The IncomingRequest class models an HTTP request.
     *
     * @return IncomingRequest
     *
     * @internal
     */
    public static function incomingrequest(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        return new IncomingRequest($config,
            new URI()
        );
    }

    /**
     * The Response class models an HTTP response.
     *
     * @return ResponseInterface
     */
    public static function response(bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('response');
        }

        return new Response();
    }

    /**
     * The Routes service is a class that allows for easily building
     * a collection of routes.
     */
    public static function routes($getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('routes');
        }

        return new RouteCollection();
    }

    /**
     * The Router class uses a RouteCollection's array of routes, and determines
     * the correct Controller and Method to execute.
     */
    public static function router(?RouteCollectionInterface $routes = null, bool $getShared = false)
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

    /**
     * The Security class provides a few handy tools for keeping the site
     * secure, most notably the CSRF protection tools.
     */
    public static function security($getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('security');
        }

        return new Security();
    }

    /**
     * @param bool $getShared
     *
     * @return Session
     */
    public static function session(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('session');
        }

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
            AppServices::response()->removeHeader('Cache-Control');

            $session->start();
        }

        return $session;
    }

    /**
     * The Timer class provides a simple way to Benchmark portions of your
     * application.
     */
    public static function timer(bool $getShared = false)
    {
        if ($getShared) {
            return static::getSharedInstance('timer');
        }

        return new Timer();
    }

    public static function toolbar(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('toolbar');
        }

        return new Toolbar();
    }

    /**
     * The URI class provides a way to model and manipulate URIs.
     */
    public static function uri(?string $uri = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('uri', $uri);
        }

        return new URI($uri);
    }

    /**
     * The Typography class provides a way to format text in semantically relevant ways.
     *
     * @return Typography
     */
    public static function typography(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('typography');
        }

        return new Typography();
    }

    /**
     * The Negotiate class provides the content negotiation features for
     * working the request to determine correct language, encoding, charset,
     * and more.
     *
     * @return Negotiate
     */
    public static function negotiator(?RequestInterface $request = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('negotiator', $request);
        }

        $request ??= AppServices::get('request');

        return new Negotiate($request);
    }

}
