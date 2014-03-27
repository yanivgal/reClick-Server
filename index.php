<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();

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
