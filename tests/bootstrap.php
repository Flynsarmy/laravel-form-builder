<?php
/**
 * Bootstraper for PHPUnit tests.
 */
error_reporting(E_ALL | E_STRICT);
$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader->add('Flynsarmy\\', __DIR__);
