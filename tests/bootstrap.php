<?php

require '../vendor/autoload.php';

// Set TEST environment
putenv('TEST=true');

print PHP_EOL . '********** reClick Tests **********' . PHP_EOL;
initiateDatabase();
initiateWebServer();

function initiateDatabase() {
    $dbName = 'reClick_test' . time();

    // Save the test db name to the env, where dbConfig can find it
    putenv('DBNAME=' . $dbName);

    $db = new \reClick\Framework\Db();

    // Create test db and execute init sql
    print 'Creating database ' . $dbName. '...' . PHP_EOL;
    $db->createTestDb();
    $dbInit = file_get_contents(__DIR__ . '/../data/reclick_init.sql');
    $db->exec($dbInit);

    // Drop the test db when done
    register_shutdown_function(function() use ($db, $dbName) {
        print PHP_EOL .'Dropping database ' . $dbName. '...' . PHP_EOL;
        $db->dropTestDb();
    });
}

function initiateWebServer() {
    $serverAddress = '127.0.0.1:9876';

    $cmd = 'php -S '
        . $serverAddress
        . ' '
        . __DIR__ . '/../index.php';

    $descriptors = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ];

    // Start web server
    print 'Starting web server (' . $serverAddress . ')...' . PHP_EOL. PHP_EOL;
    $server = proc_open(
        $cmd,
        $descriptors,
        $pipes,
        null,
        null,
        ['bypass_shell' => true]
    );

    // Terminate web server on exit
    register_shutdown_function(function () use ($server, $serverAddress) {
        print 'Terminating web server (' . $serverAddress . ')...'
            . PHP_EOL . PHP_EOL;
        proc_terminate($server);
    });
}
