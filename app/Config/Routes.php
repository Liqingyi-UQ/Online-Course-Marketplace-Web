<?php

namespace Config;

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
$routes->get('/Home/onScrollLoadMore', 'Home::onScrollLoadMore');
$routes->get('/hello', 'Hello::index');
$routes->get('/login', 'Login::index');
$routes->post('/login/check_login', 'Login::check_login');
$routes->get('/register', 'Register::index');
$routes->post('/register/check_register', 'Register::check_register');
$routes->get('/login/logout', 'Login::logout');
$routes->get('/user', 'User::index');
$routes->post('/user/update_information', 'User::update_information');
$routes->get('/upload', 'Upload::index');
$routes->post('/upload/createCourse', 'Upload::createCourse');
$routes->post('/upload/upload_basic_file', 'Upload::upload_basic_file');
$routes->get('/upload_serveral_files', 'AdvancedUpload::index');
$routes->post('/advancedUpload/fileUpload', 'AdvancedUpload::fileUpload');
$routes->post('upload/addSessionCourse', 'Upload::addSessionCourse');

$routes->get('course_profile/(:num)', 'CourseShow::index/$1');
$routes->post('courseshow/add_comment', 'CourseShow::add_comment');
$routes->post('courseshow/add_rating', 'CourseShow::add_rating');
$routes->post('courseshow/add_favorite_course', 'CourseShow::add_favorite_course');

$routes->post('emailcontroller/send', 'EmailController::send');
$routes->post('emailcontroller/verify', 'EmailController::verify');

$routes->get('/resetpassword', 'ResetPassword::index');
$routes->post('resetpassword/verify', 'ResetPassword::verify');
$routes->post('resetpassword/changepassword', 'ResetPassword::changepassword');

$routes->get('/shoppingcart', 'Shoppingcart::index');
$routes->post('/shoppingcart/process', 'Shoppingcart::process');

$routes->get('/autocompleteSearch/ajaxSearch','AutocompleteSearch::ajaxSearch');

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
