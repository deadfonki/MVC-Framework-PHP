<?php


function __autoload($class_name) {

    $filename = ucfirst($class_name) . '.php';

    $file = SitePath . '/www/Classes' . DIRSEP . $filename;


    if (file_exists($file) == false) {

        return false;

    }


    include $file;

}
__autoload('registry');
__autoload('router');
__autoload('template');
$db_params = include SitePath.'/www/settings/db_params.php';
$registry = new Registry();