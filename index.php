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
//    $gcm = new GCM();
//    $gcm->message()
//        ->addData('type', 'gameCreatedCommand')
//        ->addData('id', "1")
//        ->addData('name', "Game Added Name")
//        ->addData('description', "Game Added Description")
//        ->addData('sequence', "1")
//        ->addData('started', '1');
//
//    $players = new \reClick\Controllers\Players\Players();
//    $players = $players->getAllPlayers();
//    foreach ($players as $player) {
//        $player = new \reClick\Controllers\Players\Player($player['id']);
//        $gcm->message()->addRegistrationId($player->gcmRegId());
//    }
//
//    $gcm->sendMessage();

    $player = new \reClick\Controllers\Players\Player('y');
    $gcm = new GCM();
    $gcm->message()
        ->addData('type', 'playerMadeHisMoveCommand')
        ->addData('message', "Sample message")
        ->addData('gameId', "44")
        ->addData('sequence', "1,2,3");
    $gcm->message()->addRegistrationId($player->gcmRegId());
    $gcm->sendMessage();
});

$app->delete('/', function() use ($app) {
    print 'h';
});

$app->run();
