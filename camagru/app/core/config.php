<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	/** database config **/
	define('DBNAME', '__DBNAME__');
	define('DBHOST', '__DBHOST__');
	define('DBUSER', '__DBUSER__');
	define('DBPASS', '__DBPASS__');
	define('DBDRIVER', '');

	define('ROOT', '__ROOT__');

} else {
	/** database config **/
	define('DBNAME', 'my_db');
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBDRIVER', '');

	define('ROOT', 'https://www.yourwebsite.com');

}

define('APP_NAME', "Camagru");
define('APP_DESC', "A simple social media app for sharing photos");

/** true means show errors **/
define('DEBUG', true);
