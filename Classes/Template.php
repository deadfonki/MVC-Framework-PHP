<?php

/**
 * Created by PhpStorm.
 * User: kk
 * Date: 06.12.2017
 * Time: 21:25
 */
class Template
{

    private $registry;
    private $vars = array();


    function __construct($registry)
    {
        $this->registry = $registry;
    }


    function set($var,$val,$overwrite = false)
    {
        if (isset($this->vars[$var]) == true AND $overwrite == false) {

            trigger_error ('Unable to set var `' . $var . '`. Already set, and overwrite not allowed.', E_USER_NOTICE);

            return false;

        }


        $this->vars[$var] = $val;

        return true;
    }

    function remove($var)
    {
        unset($this->vars[$var]);
        return true;
    }
}