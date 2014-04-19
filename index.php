<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();

/* Session Route */
$app->post('/signup/', ['reClick\Routes\SessionRouter', 'signUp']);
$app->post('/login/?(hash/:hash/?)', ['reClick\Routes\SessionRouter', 'login']);

/* Game Route */
$app->get('/games/', ['reClick\Routes\GamesRouter', 'getOpenGames']);
$app->get('/games/:gameId', ['reClick\Routes\GamesRouter', 'getGame']);


$app->post('/', function() use ($app) {

    $regId = $app->request->post('regId');

    if (!isset($regId)) {
        file_put_contents('./res', 'Does not exist');
        return;
    }

    $gcm = new GCM();

    $gcm->message()
        ->addData('opponent_name', 'Yaniv Gal')
        ->addData('time', '15:10')
        ->addRegistrationId($regId);

    $response = $gcm->sendMessage();

    print $response;
});

$app->get('/', function() use ($app) {
    $hash = 'false';
//    if ($hash != 'true' && $hash != 'false') {
    if (!$hash = filter_var($hash, FILTER_VALIDATE_BOOLEAN)) {
        print 'n';
    } else {
        print 'y';
    }
});

$app->run();
