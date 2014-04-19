<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();

/* Session Routes */
$app->post(
    '/signup/',
    ['reClick\Routes\SessionRouter', 'signUp']
);
$app->post(
    '/login/?(hash/:hash/?)',
    ['reClick\Routes\SessionRouter', 'login']
);

/* Game Routes */
$app->get(
    '/games/',
    ['reClick\Routes\GameRouter', 'getOpenGames']
);
$app->get(
    '/games/:gameId',
    ['reClick\Routes\GameRouter', 'getGame']
);
$app->post(
    '/games/',
    ['reClick\Routes\GameRouter', 'createGame']
);
$app->post(
    '/games/:gameId/players/:username',
    ['reClick\Routes\GameRouter', 'addPlayerToGame']
);
$app->put(
    '/games/:gameId/players/:username',
    ['reClick\Routes\GameRouter', 'playerConfirmed']
);


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

});

$app->run();
