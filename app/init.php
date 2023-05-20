<?php

// Core Classes
// require 'classes/core/Dbh.php';
// require 'classes/core/Router.php';
// require 'classes/core/Controller.php';
// require 'classes/core/Session.php';
// require 'classes/core/Request.php';
// require 'classes/core/Response.php';

// Utility Classes
// require 'classes/utils/Validator.php';

// Include Classes

// auto loader
spl_autoload_register(function($class){
     require APP_ROOT . $class . '.php';
});