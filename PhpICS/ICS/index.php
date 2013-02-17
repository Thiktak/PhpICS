<?php

define('DIR_ICS', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * autoload function
 */
spl_autoload_register(function ($class) {
    // ICS/*.php
    // ICS/Element/*.php
    $file = DIR_ICS . preg_replace('`^ICS\\\?`', '', str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.php';
    if( file_exists($file) )
      include $file;
});

?>