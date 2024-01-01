<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 *
 */

// Create a new instance of our RouteCollection class.
$routes = DI()->single('routes');

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 */

// CodeIgniter
$routes->setDefaultNamespace('\\');
$routes->setDefaultController('news');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$route['default_controller'] = "news";
$route['404_override'] = 'errors';

//Auth
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
//$route['register'] = 'auth/register';
$route['password_recovery'] = 'auth/password_recovery';
$route['password_recovery/create_request'] = 'auth/password_recovery/create_request';
$route['password_recovery/reset_password'] = 'auth/password_recovery/reset_password';

// News
$route['news/(:num)'] = "news/index/$1";

// Pages
$route['page/admin/(:any)'] = "page/admin/$1";
$route['page/admin'] = "page/admin/index";
$route['page/(:any)'] = "page/index/$1";

// Comments
$route['news/comments/get/(:num)'] = "news/comments/get/$1";
$route['news/comments/add/(:num)'] = "news/comments/add/$1";

// Profile
$route['profile/(:num)'] = "profile/index/$1";

// Armory
$route['character/(:num)'] = "character/index/$1";
$route['character/(:num)/(:any)'] = "character/index/$1/$2";
$route['guild/(:num)/(:num)'] = "guild/index/$1/$2";
$route['tooltip/(:num)/(:num)'] = "tooltip/index/$1/$2";
$route['item/(:num)/(:num)'] = "item/index/$1/$2";

// Admin
$route['admin/edit/save/(:any)'] = "admin/edit/save/$1";
$route['admin/edit/saveSource/(:any)'] = "admin/edit/saveSource/$1";
$route['admin/edit/(:any)'] = "admin/edit/index/$1";
$route['admin/theme/edit/save/(:any)/(:any)'] = "admin/edittheme/save/$1/$2";
$route['admin/theme/edit/saveSource/(:any)/(:any)'] = "admin/edittheme/saveSource/$1/$2";
$route['admin/theme/edit/(:any)'] = "admin/edittheme/index/$1";
$route['admin/theme/edit'] = "admin/edittheme/index";

// Vote
$route['vote/callback/(:any)'] = "vote/callback/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
