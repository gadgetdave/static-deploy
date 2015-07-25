<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

define('APPLICATION_ROOT', realpath(dirname(__DIR__)));

// include path be specifically set
if (getenv('includePath')) {
    define('ORIGINAL_INCLUDE_PATH', getenv('includePath'));
    ini_set('include_path', ORIGINAL_INCLUDE_PATH);
    
// update include path to include application root and src folder
} else {
    define('ORIGINAL_INCLUDE_PATH', ini_get('include_path'));
    $includePath = ORIGINAL_INCLUDE_PATH;
    $includePath.= PATH_SEPARATOR . APPLICATION_ROOT
                 . DIRECTORY_SEPARATOR . 'src';
    $includePath.= PATH_SEPARATOR . APPLICATION_ROOT;
    
    // add any additional include paths
    if (getenv('extraIncludes')) {
        $includePath.= PATH_SEPARATOR . getenv('extraIncludes');
    }
    ini_set('include_path', $includePath);
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup composer autoloading, which also includes zf2
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}
/* // Setup autoloading
require 'init_autoloader.php'; */

// add zend autoloader and set fallback_autoloader to true to allow us to
// register namespaces that will be detected via the include_path
$loader = new Zend\Loader\StandardAutoloader(
    array(
        'autoregister_zf' => true,
        'fallback_autoloader' => true
    )
);
$loader->registerNamespace('MyApp', 'MyApp');
$loader->register();

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
