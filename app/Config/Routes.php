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
$routes->get('/personal-loan', 'Home::personalLoan');
$routes->post('/personal-loan/send-otp', 'Home::sendOTP');
$routes->get('/personal-loan/verify-otp', 'Home::verifyOTP');
$routes->post('/personal-loan/verify-otp/process', 'Home::verifyOtpProcess');
$routes->get('/personal-loan/employment-type', 'Home::employmentType');
$routes->post('/personal-loan/employment-type/process', 'Home::employmentTypeProcess');
$routes->get('/personal-loan/employer', 'Home::employer');
$routes->post('/personal-loan/employer/process', 'Home::employerProcess');
$routes->get('/personal-loan/income', 'Home::income');
$routes->post('/personal-loan/income/process', 'Home::incomeProcess');
$routes->get('/personal-loan/loanAmount', 'Home::loanAmount');
$routes->post('/personal-loan/loanAmount/process', 'Home::loanAmountProcess');
$routes->get('/personal-loan/primary-bank', 'Home::primaryBank');
$routes->post('/personal-loan/primary-bank/process', 'Home::primaryBankProcess');
$routes->get('/personal-loan/residence', 'Home::residence');
$routes->post('/personal-loan/residence/process', 'Home::residenceProcess');
$routes->get('/personal-loan/residenceType', 'Home::residenceType');
$routes->post('/personal-loan/residenceType/process', 'Home::residenceTypeProcess');
$routes->get('/personal-loan/personal-details', 'Home::personalDetails');
$routes->post('/personal-loan/personal-details/process', 'Home::personalDetailsProcess');
$routes->get('/personal-loan/offers', 'Home::offers');
$routes->post('/personal-loan/offers/apply', 'Home::offerApply');
$routes->get('/personal-loan/offers', 'Home::index');
// $routes->get('login', 'Login::index');
// $routes->get('personal-loans', 'Home::personalLoan');
// $routes->get('register', 'Register::index');
// $routes->get('verify-email', 'Home::VerifyEmail');
// $routes->post('verify-email-process', 'Home::VerifyEmailProcess');
// $routes->post('verify-otp', 'Home::verifyOTP');

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
//$route['default_controller'] = 'login';