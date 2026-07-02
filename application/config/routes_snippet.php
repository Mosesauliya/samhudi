<?php
// Tambahin ini ke application/config/routes.php lo (jangan replace semua)

$route['auth']                      = 'auth/index';
$route['auth/login']                = 'auth/login';
$route['auth/register']             = 'auth/register';
$route['auth/verify_otp']           = 'auth/verify_otp';
$route['auth/resend_otp']           = 'auth/resend_otp';
$route['auth/forgot_password']      = 'auth/forgot_password';
$route['auth/reset_password/(:any)'] = 'auth/reset_password/$1';
$route['auth/logout']               = 'auth/logout';

// Kalau mau auth jadi landing page:
// $route['default_controller'] = 'auth';
