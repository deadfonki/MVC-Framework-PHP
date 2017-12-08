<?php

/**
 * Created by PhpStorm.
 * User: kk
 * Date: 06.12.2017
 * Time: 20:59
 */
class Router
{
    private $registry;
    private $path;
    private $args = Array();

    function __construct($registry)
    {
        $this->registry = $registry;
    }


    function setPath($path)
    {
        $path = trim($path,'/');
        $path  .=DIRSEP;


        if (!is_dir($path))
        {
            throw  new Exception("invalid controller path:`".$path."`");

        }

        $this->path = $path;
    }


    function delegate()
    {
        $this->GetController($file,$controller,$action,$args);
        if (is_readable($file) == false) {

            die ('404 Not Found');

        }


        // Подключаем файл

        include ($file);


        // Создаём экземпляр контроллера

        $class = ucfirst($controller) . 'Controller';

        $controller = new $class($this->registry);


        // Действие доступно?

        if (is_callable(array($controller, $action)) == false) {

            die ('404 Not Found');

        }


        // Выполняем действие

        $controller->$action();
    }

    private function getController(&$file, &$controller, &$action, &$args)
    {

        $route = (empty($_SERVER['REQUEST_URI'])) ? '' : $_SERVER['REQUEST_URI'];


        if (empty($route)) {

            $route = 'index';
        }


        // Получаем раздельные части

        $route = trim($route, '/');

        $parts = explode('/', $route);

        // Находим правильный контроллер

        $cmd_path = $this->path;

        foreach ($parts as $part) {

            $fullpath = $cmd_path . ucfirst($part).'Controller';



            // Есть ли папка с таким путём?

            if (is_dir($fullpath)) {

                $cmd_path .= $part . DIRSEP;

                array_shift($parts);

                continue;

            }


            // Находим файл

            if (is_file($fullpath . '.php')) {

                $controller = $part;

                array_shift($parts);

                break;

            }


        }


        if (empty($controller)) {

            $controller = 'index';
        };


        // Получаем действие

        $action = array_shift($parts);

        if (empty($action)) {
            $action = 'index';
        }


        $file = $cmd_path .ucfirst($controller)  . "Controller". '.php';

        $args = $parts;

    }


}