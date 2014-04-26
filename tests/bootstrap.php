<?php

print PHP_EOL . '********** reClick Tests **********' . PHP_EOL . PHP_EOL;

//start server
$serverAddress = '127.0.0.1:9876';
define('REST_SERVER', 'http://' . $serverAddress);

$cmd = 'php -S '
    . $serverAddress
    . ' '
    . __DIR__ . '/../index.php';

require '../vendor/autoload.php';

// Set TEST environment
putenv('TEST=true');

$dbName = 'reClick_test' . time();

// Save the test db name to the env, where dbConfig can find it
putenv('DBNAME=' . $dbName);

$db = new \reClick\Framework\Db();

print 'Create database ' . $dbName. '...' . PHP_EOL. PHP_EOL;

// Create test db and execute init sql
$db->createTestDb();
$dbInit = file_get_contents(__DIR__ . '/../data/reclick_init.sql');
$db->exec($dbInit);

// Delete the test db when done
register_shutdown_function(function() use ($db, $dbName) {
    print PHP_EOL . 'Drop database ' . $dbName. '...' . PHP_EOL . PHP_EOL;
    $db->dropTestDb();
});
