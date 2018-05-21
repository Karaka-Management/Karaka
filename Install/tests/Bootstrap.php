<?php

ini_set('memory_limit', '2048M');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/Autoloader.php';
$CONFIG = require_once __DIR__ . '/../../config.php';

use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;

// Reset database
$db = new \PDO($CONFIG['db']['core']['masters']['admin']['db'] . ':host=' .
    $CONFIG['db']['core']['masters']['admin']['host'],
    $CONFIG['db']['core']['masters']['admin']['login'],
    $CONFIG['db']['core']['masters']['admin']['password']
);
$db->exec('DROP DATABASE IF EXISTS ' .  $CONFIG['db']['core']['masters']['admin']['database']);
$db->exec('CREATE DATABASE IF NOT EXISTS ' .  $CONFIG['db']['core']['masters']['admin']['database']);
$db = null;

$httpSession = new HttpSession();
$GLOBALS['session'] = $httpSession;

$GLOBALS['dbpool'] = new DatabasePool();
$GLOBALS['dbpool']->create('admin', $CONFIG['db']['core']['masters']['admin']);
$GLOBALS['dbpool']->create('select', $CONFIG['db']['core']['masters']['select']);

DataMapperAbstract::setConnection($GLOBALS['dbpool']->get());
