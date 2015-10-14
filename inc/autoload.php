<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/10/15
 * Time: 12:01
 */

require_once('config.php');


function __autoload($class_name){

    $class = explode("_", $class_name);
    $path = implode("/", $class) . ".php";
    require_once($path);

}