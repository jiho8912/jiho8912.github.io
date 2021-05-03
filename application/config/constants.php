<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('Url', $_SERVER['HTTP_HOST']);
define('Root_dir', dirname(FCPATH));
define('Img_dir','/application/views/images');
define('board_Img_dir','/application/views/board/images');
define('plugin_dir','/application/views/plugin');
define('CSS_DIR','/application/views/plugin');
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
define('NAVER_CLIENT_ID', 'IO1m4JaZnzAAmrPQ6q6j');
define('NAVER_CLIENT_SECRET', 'W3siSrPP9C');
define('NAVER_CALLBACK_URL', 'http://' . urlencode($_SERVER['HTTP_HOST'] . '/member/callback_url'));
define('KAKAO_APP_KEY', '5eb1767728ef3efdecfd82e20535b95b');
define('KAKAO_CALLBACK_URL', 'http://' . urlencode($_SERVER['HTTP_HOST'] . '/member/callback_url_kakao'));
define('KAKAO_CLIENT_SECRET', '20YB8VbGpPX7xlA6x9I68N2O2KLi76OA');


/* End of file constants.php */
/* Location: ./application/config/constants.php */