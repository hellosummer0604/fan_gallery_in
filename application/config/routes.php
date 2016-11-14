<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/**
 * first class router name
 *
 * 1) ./resource/
 * 2) ./upload/
 * 3) ./account/
 * 4) ./{shortUrl}/
 *
 *
 */


$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['/'] = 'home/index';
$route['homepage/(:any)'] = 'Ajax_controller/getImg/null/$1';
$route['homepage/(:any)/page/(:num)'] = 'Ajax_controller/getImg/null/$1/$2';

//for signup, login, logout, retrieve
$route['account/signup']['post'] = 'Home/signup';
$route['account/userId']['get'] = 'Home/currentUserId';
$route['account/login']['post'] = 'Home/login';
$route['account/logout'] = 'Home/logout';
$route['account/retrieve'] = 'Home/retrieve';

//for html component
$route['component/head'] = 'Home/headNav';
$route['component/imgPopup/(:num)'] = 'Home/imgPopup/$1';
$route['component/imgPopupEdit/(:num)'] = 'Home/imgPopupEdit/$1';

//upload
$route['upload'] = 'Currentuser/moduleUpload/';
$route['upload/file'] = 'Currentuser/uploadFile/';
$route['upload/complete'] = 'Currentuser/completeUpload/';
$route['upload/delete'] = 'Currentuser/deleteTmpFile/';
$route['upload/deleteAll'] = 'Currentuser/deleteAllTmpFile/';

//Image
$route['image/(:any)'] = "Image_controller/$1";
$route['image/(:num)/edit']['post'] = "Image_controller/update/$1/";
$route['image/(:any)/(:any)'] = "Image_controller/$1/$2";
$route['image/(:any)/(:any)/(:any)'] = "Image_controller/$1/$2/$3";
$route['image/(:any)/(:any)/(:any)/(:any)'] = "Image_controller/$1/$2/$3/$4";


//for current user
$route['u/(:any)'] = 'Currentuser/$1';
$route['u/(:any)/(:any)'] = 'Currentuser/$1/$2';
$route['u/(:any)/(:any)/(:any)'] = 'Currentuser/$1/$2/$3';
$route['u/(:any)/(:any)/(:any)/(:any)'] = 'Currentuser/$1/$2/$3/$4';


$route['user/(:any)'] = "home/index/$1";
$route['user/'.REPO_URL] = "Currentuser/".REPO_URL;
$route['user/'.REPO_URL."/tag/(:any)"] = "Currentuser/".REPO_URL;
$route['user/(:any)/tag/(:any)']['post'] = "Ajax_controller/getImg/$1/$2";
$route['user/(:any)/tag/(:any)']['get'] = "home/index/$1";
$route['user/(:any)/tags'] = "Currentuser/getAllTags/$1";
$route['user/(:any)/tag/(:any)/page/(:num)']['post'] = "Ajax_controller/getImg/$1/$2/$3";

$route['cron'] = "Cron_controller/test";
$route['cron/(:any)'] = "Cron_controller/$1";
$route['cron/(:any)/(:any)'] = "Cron_controller/$1/$2";

//settings
$route['settings'] = 'Currentuser/moduleSettings/';
$route['commingSoon'] = 'Currentuser/commingSoon/';