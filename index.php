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

    $apiKey = 'AIzaSyCwEmCaqZzIkD3KLm57IJ3ZarIeo-6Zaxg';
    $gcm = new GCM($apiKey);

    $gcm->message()
        ->addData('opponent_name', 'Yaniv Gal')
        ->addData('time', '15:10')
        ->addRegistrationId($regId);

    $response = $gcm->sendMessage();

    print $response;
});

$app->get('/', function() use ($app) {
    $db = new \reClick\Framework\Db();
    $res = $db->query('select username from players where id = :id', ['id' => 1]);
//    $res = $db->query('show tables');
    echo'<pre>';print_r($res);exit;
});

$app->run();
