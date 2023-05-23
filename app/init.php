<?php

// auto loader
spl_autoload_register(function($className){
     require APP_ROOT . $className . '.php';
});