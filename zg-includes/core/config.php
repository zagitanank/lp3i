<?php

$site['structure'] = 'Zagitanank';
$site['ver'] = '1.0';
$site['build'] = '1';
$site['release'] = '21 September 2023';

define('CONF_STRUCTURE', $site['structure']);
define('CONF_VER', $site['ver']);
define('CONF_BUILD', $site['build']);
define('CONF_RELEASE', $site['release']);

$site['url'] = "http://localhost/polinas/";
$site['adm'] = "admin";
$site['con'] = "zg-content";
$site['inc'] = "zg-includes";
$site['siaka'] = "https://siska.unifa.ac.id/upload/";

define('WEB_URL', $site['url']);
define('DIR_ADM', $site['adm']);
define('DIR_CON', $site['con']);
define('DIR_INC', $site['inc']);
define('URL_SIAKA', $site['siaka']);

$db['host'] = "localhost";
$db['driver'] = "mysql";
$db['sock'] = "";
$db['port'] = "";
$db['user'] = "root";
$db['passwd'] = "";
$db['db'] = "polinas";

define('DATABASE_HOST', $db['host']);
define('DATABASE_DRIVER', $db['driver']);
define('DATABASE_SOCK', $db['sock']);
define('DATABASE_PORT', $db['port']);
define('DATABASE_USER', $db['user']);
define('DATABASE_PASS', $db['passwd']);
define('DATABASE_NAME', $db['db']);

$site['vqmod'] = FALSE;
$site['timezone'] = "Asia/Makassar";
$site['permalink'] = "slug/post-title";
$site['slug_permalink'] = "detailpost";

define('VQMOD', $site['vqmod']);
define('TIMEZONE', $site['timezone']);
define('PERMALINK', $site['permalink']);
define('SLUG_PERMALINK', $site['slug_permalink']);