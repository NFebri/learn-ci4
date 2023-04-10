<?php

namespace Config;

use App\Controllers\NewsController;
use App\Controllers\RoleController;
use App\Controllers\UserController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// news
$routes->get('news', [NewsController::class, 'index'], ['filter' => 'permission:news-show', 'as' => 'news_index']);
$routes->get('news/get-datatables', [NewsController::class, 'getDatatables'], ['filter' => 'permission:news-show', 'as' => 'news_datatables']);
$routes->get('news/create', [NewsController::class, 'create'], ['filter' => 'permission:news-create', 'as' => 'news_create']);
$routes->post('news', [NewsController::class, 'store'], ['filter' => 'permission:news-create', 'as' => 'news_store']);
$routes->get('news/edit/(:num)', [NewsController::class, 'edit'], ['filter' => 'permission:news-edit', 'as' => 'news_edit']);
$routes->put('news/edit/(:num)', [NewsController::class, 'update'], ['filter' => 'permission:news-edit', 'as' => 'news_update']);
$routes->delete('news/(:num)', [NewsController::class, 'destroy'], ['filter' => 'permission:news-delete', 'as' => 'news_destroy']);

// user
$routes->get('users', [UserController::class, 'index'], ['filter' => 'permission:users-show', 'as' => 'users_index']);
$routes->get('users/get-datatables', [UserController::class, 'getDatatables'], ['filter' => 'permission:users-show', 'as' => 'users_datatables']);
$routes->get('users/create', [UserController::class, 'create'], ['filter' => 'permission:users-create', 'as' => 'users_create']);
$routes->post('users', [UserController::class, 'store'], ['filter' => 'permission:users-create', 'as' => 'users_store']);

// role
$routes->get('roles', [RoleController::class, 'index'], ['filter' => 'permission:roles-show', 'as' => 'roles_index']);
$routes->get('roles/get-datatables', [RoleController::class, 'getDatatables'], ['filter' => 'permission:roles-show', 'as' => 'roles_datatables']);
$routes->get('roles/edit/(:num)', [RoleController::class, 'edit'], ['filter' => 'permission:roles-edit', 'as' => 'roles_edit']);
$routes->put('roles/edit/(:num)', [RoleController::class, 'update'], ['filter' => 'permission:roles-edit', 'as' => 'roles_update']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
