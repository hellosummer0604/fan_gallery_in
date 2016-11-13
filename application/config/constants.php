<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('WEN_INDEX', 'http://north.gallery/');
define('WEN_LOGIN', 'http://north.gallery/login');
define('WEN_NO_REDIRECT', 'none');

define('ARB_activationKey', 'asvya123g_vukglby'); //cron password
//define('ARB_activationKey', 'asd'); //cron password

define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//
define('IMG_SECTION_PAGE_NO', 0);
define('IMG_SECTION_PAGE_SIZE', 150);
define('IMG_SECTION_SIZE', 24);
define('IMG_SECTION_LAST_SIZE', 20);

//test
//define('IMG_SECTION_PAGE_NO', 0);
//define('IMG_SECTION_PAGE_SIZE', 10);
//define('IMG_SECTION_SIZE', 6);
//define('IMG_SECTION_LAST_SIZE', 6);

define('SESSION_USER_ID', 'onlineUserId');
define('SESSION_UPLOAD', 'sessUpload');
define('ONLINE_FLAG', 'xxIsOnline');

define('TYPE_USER', 1);

define('RND_KEY_RETRY', 10);

define('DROP_ZONE_FILE_MAX_SIZE', 5);
define('DROP_ZONE_FILE_MAX_COUNT', 15);
define('FILE_UPLOAD_TEMP_PATH', 'tmp/img_upload/');
define('FILE_UPLOAD_TYPE', 'gif|jpg|jpeg|png');
define('FILE_UPLOAD_SECTION_DAYS', '10');//split month by sections, section has 10 days
define('FILE_UPLOAD_FOLDER_PERMISSION', 0755);// to be decided


define('IMG_STATE_REPO', 1);//In repository, only owner can find it in repository page
define('IMG_STATE_PRIVATE', 2);//only owner
define('IMG_STATE_PUBLIC', 3);//all the user

define('FILE_HD_PATH', 'resource/gallery/img_publish/img_hd/');
define('FILE_THUMB_PATH', 'resource/gallery/img_publish/img_thumb/');
define('THUMB_MIN_WIDTH', 500);
define('THUMB_MIN_HEIGHT', 500);
define('THUMB_SIZE', 500);

define('IMG_UNASSIGNED', 'default');


define('REPO_ID', 'repo_id');
define('REPO_URL', 'infocenter');

define('TAG_ALL', 'all_id');
define('TAG_NEW', 'new_id');
define('TAG_POPULAR', 'popular_id');
define('TAG_FEATURED', 'featured_id');

define('TAG_IMG_LEAST', 0);


define('USER_ID_LEN', 32);



