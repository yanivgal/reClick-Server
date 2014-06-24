<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();
new \reClick\Framework\Bootstrap();

$app->post('/', function() use ($app) {

    $player = new \reClick\Controllers\Players\Player('q');
    $regId = $player->gcmRegId();

//    print $regId;exit;

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

$app->delete('/', function() use ($app) {
    print 'h';
});

$app->run();
