<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();

$app->post('/signup/', ['reClick\Routes\Session', 'signUp']);
$app->post('/login/?(hash/:hash/?)', ['reClick\Routes\Session', 'login']);

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
    print '{"status":"success"}';
});

$app->run();

/**
 * @param array $requestObject
 * @param array $expectedVars
 * @return array
 */
function initRequestVars($requestObject, $expectedVars) {
    $initVars = [];

    foreach ($expectedVars as $expectedVar) {
        $initVars[$expectedVar] = isset($requestObject[$expectedVar])
            ? $requestObject[$expectedVar] : null;
    }

    return $initVars;
}
