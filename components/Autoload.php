<?php

/**
 * ф-ця __autoload для автоматичного підключення класів
 */
function __autoload($class_name)
{
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    foreach ($array_paths as $path) {

        // формуєм ім'я та шлях до класів
        $path = ROOT . $path . $class_name . '.php';

        if (is_file($path)) {
            include_once $path;
        }
    }	
}
