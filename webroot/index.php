<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT . DS . 'views');
define('PRELINK',substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], "webroot/index.php")));//префикс для внутренних ссылок, чтобы не зависеть от расположения каталога сайта относительно базового каталога


require_once(ROOT . DS . 'lib' . DS . 'init.php');

try {
    session_start();
    App::run($_SERVER['REQUEST_URI']);

} catch (Exception $e) {
    echo $e->getMessage();
}

