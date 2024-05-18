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
use CodeIgniter\Autoloader\Autoloader;
use CodeIgniter\Autoloader\FileLocator;
use CodeIgniter\Autoloader\FileLocatorCached;
use CodeIgniter\Autoloader\FileLocatorInterface;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Database\MigrationRunner;
use CodeIgniter\Debug\Exceptions;
use CodeIgniter\Debug\Iterator;
use CodeIgniter\Debug\Timer;
use CodeIgniter\Debug\Toolbar;
use CodeIgniter\Email\Email;
use CodeIgniter\Format\Format;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\URI;
use CodeIgniter\Log\Logger;
use CodeIgniter\Router\RouteCollection;
use CodeIgniter\Router\RouteCollectionInterface;
use CodeIgniter\Router\Router;
use CodeIgniter\Security\Security;
use CodeIgniter\Session\Session;
use CodeIgniter\Typography\Typography;
use App\Config\App;
use Config\Optimize;
use App\Config\Exceptions as ConfigExceptions;
use App\Config\Services as AppServices;
use Config\Format as ConfigFormat;
use InvalidArgumentException;

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
 * Warning: To allow overrides by service providers do not use static calls,
 * instead call out to \Config\Services (imported as AppServices).
 *
 * @see http://blog.ircmaxell.com/2015/11/simple-easy-risk-and-change.html
 * @see http://www.infoq.com/presentations/Simple-Made-Easy
 *
 * @method static CLIRequest                 clirequest($getShared = true)
 * @method static void                       createRequest(?App $config = null, bool $isCli = false)
 * @method static CURLRequest                curlrequest($options = [], ResponseInterface $response = null, $getShared = true)
 * @method static Email                      email($config = null, $getShared = true)
 * @method static Exceptions                 exceptions(ConfigExceptions $config = null, $getShared = true)
 * @method static Format                     format(ConfigFormat $config = null, $getShared = true)
 * @method static IncomingRequest            incomingrequest(?App $config = null, bool $getShared = true)
 * @method static Iterator                   iterator($getShared = true)
 * @method static Logger                     logger($getShared = true)
 * @method static MigrationRunner            migrations(Migrations $config = null, ConnectionInterface $db = null, $getShared = true)
 * @method static IncomingRequest|CLIRequest request(?App $config = null, $getShared = true)
 * @method static ResponseInterface          response($getShared = true)
 * @method static Router                     router(RouteCollectionInterface $routes = null, $getShared = true)
 * @method static RouteCollection            routes($getShared = true)
 * @method static Security                   security($getShared = true)
 * @method static Session                    session($getShared = true)
 * @method static Timer                      timer($getShared = true)
 * @method static Toolbar                    toolbar($getShared = true)
 * @method static Typography                 typography($getShared = true)
 * @method static URI                        uri($uri = null, $getShared = true)
 */
class BaseService
{
    /**
     * Cache for instance of any services that
     * have been requested as a "shared" instance.
     * Keys should be lowercase service names.
     *
     * @var array<string, object> [key => instance]
     */
    protected static $instances = [];

    /**
     * Factory method list.
     *
     * @var array<string, (callable(mixed ...$params): object)> [key => callable]
     */
    protected static array $factories = [];

    /**
     * Mock objects for testing which are returned if exist.
     *
     * @var array<string, object> [key => instance]
     */
    protected static $mocks = [];

    /**
     * A cache of other service classes we've found.
     *
     * @var array
     *
     * @deprecated 4.5.0 No longer used.
     */
    protected static $services = [];

    /**
     * A cache of the names of services classes found.
     *
     * @var list<string>
     */
    private static array $serviceNames = [];

    /**
     * Simple method to get an entry fast.
     *
     * @param string $key Identifier of the entry to look for.
     *
     * @return object|null Entry.
     */
    public static function get(string $key): ?object
    {
        return static::$instances[$key] ?? static::__callStatic($key, []);
    }

    /**
     * Sets an entry.
     *
     * @param string $key Identifier of the entry.
     */
    public static function set(string $key, object $value): void
    {
        if (isset(static::$instances[$key])) {
            throw new InvalidArgumentException('The entry for "' . $key . '" is already set.');
        }

        static::$instances[$key] = $value;
    }

    /**
     * Overrides an existing entry.
     *
     * @param string $key Identifier of the entry.
     */
    public static function override(string $key, object $value): void
    {
        static::$instances[$key] = $value;
    }

    /**
     * Returns a shared instance of any of the class' services.
     *
     * $key must be a name matching a service.
     *
     * @param array|bool|float|int|object|string|null ...$params
     *
     * @return object
     */
    protected static function getSharedInstance(string $key, ...$params)
    {
        $key = strtolower($key);

        // Returns mock if exists
        if (isset(static::$mocks[$key])) {
            return static::$mocks[$key];
        }

        if (! isset(static::$instances[$key])) {
            // Make sure $getShared is false
            $params[] = false;

            static::$instances[$key] = AppServices::$key(...$params);
        }

        return static::$instances[$key];
    }

    /**
     * The Autoloader class is the central class that handles our
     * spl_autoload_register method, and helper methods.
     *
     * @return Autoloader
     */
    public static function autoloader(bool $getShared = true)
    {
        if ($getShared) {
            if (empty(static::$instances['autoloader'])) {
                static::$instances['autoloader'] = new Autoloader();
            }

            return static::$instances['autoloader'];
        }

        return new Autoloader();
    }

    /**
     * The file locator provides utility methods for looking for non-classes
     * within namespaced folders, as well as convenience methods for
     * loading 'helpers', and 'libraries'.
     *
     * @return FileLocatorInterface
     */
    public static function locator(bool $getShared = true)
    {
        if ($getShared) {
            if (empty(static::$instances['locator'])) {
                $cacheEnabled = class_exists(Optimize::class)
                    && (new Optimize())->locatorCacheEnabled;

                if ($cacheEnabled) {
                    static::$instances['locator'] = new FileLocatorCached(new FileLocator(static::autoloader()));
                } else {
                    static::$instances['locator'] = new FileLocator(static::autoloader());
                }
            }

            return static::$mocks['locator'] ?? static::$instances['locator'];
        }

        return new FileLocator(static::autoloader());
    }

    /**
     * Provides the ability to perform case-insensitive calling of service
     * names.
     *
     * @return object|null
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (isset(static::$factories[$name])) {
            return static::$factories[$name](...$arguments);
        }

        $service = static::serviceExists($name);

        if ($service === null) {
            return null;
        }

        return $service::$name(...$arguments);
    }

    /**
     * Check if the requested service is defined and return the declaring
     * class. Return null if not found.
     */
    public static function serviceExists(string $name): ?string
    {
        $services = array_merge(self::$serviceNames, [Services::class]);
        $name     = strtolower($name);

        foreach ($services as $service) {
            if (method_exists($service, $name)) {
                static::$factories[$name] = [$service, $name];

                return $service;
            }
        }

        return null;
    }

    /**
     * Reset shared instances and mocks for testing.
     *
     * @return void
     */
    public static function reset(bool $initAutoloader = true)
    {
        static::$mocks     = [];
        static::$instances = [];
        static::$factories = [];

        if ($initAutoloader) {
            static::autoloader()->initialize(get_config2('autoload'));
        }
    }

    /**
     * Resets any mock and shared instances for a single service.
     *
     * @return void
     */
    public static function resetSingle(string $name)
    {
        $name = strtolower($name);
        unset(static::$mocks[$name], static::$instances[$name]);
    }

    /**
     * Inject mock object for testing.
     *
     * @param object $mock
     *
     * @return void
     */
    public static function injectMock(string $name, $mock)
    {
        static::$instances[$name]         = $mock;
        static::$mocks[strtolower($name)] = $mock;
    }
}