<?php
/**
 * Autoloads core/, models/ and controllers/ classes by matching
 * the class name to a file of the same name.
 */
spl_autoload_register(function ($class) {
    foreach (['core', 'models', 'controllers'] as $dir) {
        $path = __DIR__ . '/../' . $dir . '/' . $class . '.php';

        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});
