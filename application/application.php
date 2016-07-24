<?php
/**
 * Created by PhpStorm.
 * User: georgimorozov
 * Date: 7/20/16
 * Time: 12:47 PM
 */
$paths = array(
    get_include_path(),
    '../library',
);
set_include_path(implode(PATH_SEPARATOR, $paths));
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', 'development');
require_once 'Zend/Application.php';
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH.'/config/store.ini'
);
$application->bootstrap()->run();
