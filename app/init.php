<?php

spl_autoload_register(function($class){
    require_once 'Core/'.$class.'.php';
});

$GLOBALS['path'] = "/mini-framework-php/public/";