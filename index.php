<?php

/**
 * Show display Errors
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Start Session
 */
session_start();

/**
 * Connecting system file
 */
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

/**
 * call Router
 */
$router = new Router();
$router->run();