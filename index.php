<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();
new \reClick\Framework\Bootstrap();

$app->post('/', function() use ($app) {

    $player = new \reClick\Controllers\Players\Player('a');
    $regId = $player->gcmRegId();

//    print $regId;exit;

    $game = new \reClick\Controllers\Games\Game(63);

    $gcm = new GCM();

    $gcm->message()
        ->addData('message', 'Yaniv Gal')
        ->addData('gameId', '64')
        ->addData('sequence', '1,2,3')
        ->addRegistrationId($regId);

    $response = $gcm->sendMessage();

    print $response;
});

$app->get('/', function() use ($app) {

});

$app->delete('/', function() use ($app) {
    print 'h';
});

$app->run();
