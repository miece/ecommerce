<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/10/15
 * Time: 12:40
 */


class Core{


    public function run(){
        ob_start();

        require_once(Url::getPage());
        ob_get_flush();

    }


}


