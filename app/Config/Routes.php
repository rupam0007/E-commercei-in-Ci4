<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Home ───────────────────────────────────────────────────────────────────────
$routes->get('/', 'ShopController::home');

// ── Auth (public) ──────────────────────────────────────────────────────────────
$routes->get('register',  'AuthController::registerForm');
$routes->post('register', 'AuthController::register');
$routes->get('login',     'AuthController::loginForm');
$routes->post('login',    'AuthController::login');
$routes->get('logout',    'AuthController::logout');

// ── Shop (public) ──────────────────────────────────────────────────────────────
$routes->get('shop',           'ShopController::index');
$routes->get('shop/(:segment)', 'ShopController::show/$1');

// ── Customer protected routes ──────────────────────────────────────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Cart
    $routes->get('cart',              'CartController::index');
    $routes->post('cart/add',         'CartController::add');
    $routes->post('cart/update',      'CartController::update');
    $routes->get('cart/remove/(:num)', 'CartController::remove/$1');

    // Checkout & Orders
    $routes->get('checkout',          'OrderController::checkoutForm');
    $routes->post('checkout',         'OrderController::checkout');
    $routes->get('orders',            'OrderController::index');
    $routes->get('orders/(:num)',     'OrderController::show/$1');

    // Profile
    $routes->get('profile',              'UserController::profile');
    $routes->get('profile/edit',         'UserController::editProfile');
    $routes->post('profile/edit',        'UserController::updateProfile');
    $routes->post('profile/password',    'UserController::updatePassword');
});

// ── Admin protected routes ────────────────────────────────────────────────────
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard',                    'AdminController::dashboard');

    // Products
    $routes->get('products',                     'AdminController::products');
    $routes->get('products/create',              'AdminController::createProduct');
    $routes->post('products/create',             'AdminController::storeProduct');
    $routes->get('products/edit/(:num)',         'AdminController::editProduct/$1');
    $routes->post('products/update/(:num)',      'AdminController::updateProduct/$1');
    $routes->get('products/delete/(:num)',       'AdminController::deleteProduct/$1');

    // Orders
    $routes->get('orders',                       'AdminController::orders');
    $routes->post('orders/status/(:num)',        'AdminController::updateOrderStatus/$1');

    // Categories
    $routes->get('categories',                   'AdminController::categories');
    $routes->post('categories',                  'AdminController::storeCategory');
    $routes->get('categories/delete/(:num)',     'AdminController::deleteCategory/$1');

    // Customers
    $routes->get('customers',                    'AdminController::customers');

    // Reports
    $routes->get('reports',                      'AdminController::reports');
});
