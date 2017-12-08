<?php

error_reporting (E_ALL);

//Constants

define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__).DIRSEP.'..'.DIRSEP).DIRSEP;

define('SitePath',$site_path);



//Constants

//includes
include '/includes/startup.php';



//includes


//db connection
$dsn = 'mysql:host='.$db_params['host'].';dbname='.$db_params['db'];
$db = new PDO($dsn,$db_params['username'],$db_params['password']);
$registry->set('db',$db);


//db connection

//init
$router = new Router($registry);
$registry->set('router',$router);
$router->setPath(SitePath.'/www/Controllers');

$router->delegate();

$template = new Template($registry);
$registry->set('template',$template);

//
