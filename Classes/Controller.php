<?php

/**
 * Created by PhpStorm.
 * User: kk
 * Date: 06.12.2017
 * Time: 21:11
 */
Abstract class Controller
{
    protected $registry;
    public $content;
    private $layout;

    private $classname;
    private $controllername;
    function __construct($registry)
    {
        $this->classname = get_called_class();
        ob_start(null,null,true);
        $this->layout = include (SitePath.'/www/Views/layouts/main.php');

        $this->registry = $registry;
        $this->controllername = explode('Controller',$this->classname);
        $this->controllername = $this->controllername[0];

    }

   protected function render($file)
    {
        $path = '';
        if (ucfirst($this->controllername) != 'index')
        {
            $path = SitePath.'/www/Views/'.$this->controllername;
        }
        else
        {
            $path = SitePath.'/www/Views/site';
        }
        $filename = $path.'/'.$file;
        if (substr($file,-3) == 'php')
        {
            $filename = $path.'/'.$file;
        }
        else
        {
            $filename = $path.'/'.$file.'.php';
        }
        if (file_exists($filename))
        {
            ob_end_clean();
            $this->content = include ($filename);
        }
        else
        {
            throw  new Exception('View файл не найден');
        }


    }
    protected function setLayout($layoutname)
    {
        $path = SitePath.'/www/Views/layouts';
         $filename = $path.'/'.$layoutname;
        if (substr($layoutname,-3) == 'php')
        {
            $filename = $path.'/'.$layoutname;
        }
        else
        {
            $filename = $path.'/'.$layoutname.'.php';
        }

        if (file_exists($filename))
        {
            ob_end_clean();
            $this->content = include ($filename);
        }
        else
        {
            throw  new Exception('View файл не найден');
        }
    }

    abstract function index();

}