<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;

$app = new \Slim\Slim();

$app->post('/register/', function() use ($app) {

    $expectedVars = [
        'username',
        'password',
        'nickname',
        'gcmRegId'
    ];
    $requestVars = initRequestVars($app->request->post(), $expectedVars);

    $player = new \reClick\Controllers\Players\Player();
    try {
        $player->create(
            $requestVars['username'],
            $requestVars['password'],
            $requestVars['nickname'],
            $requestVars['gcmRegId']
        );
    } catch (PDOException $e) {
        print $e->getMessage();
        $response['status'] = 'failed';
        $response['message'] = 'Some message';
        exit;
    } catch (Exception $e) {
        //TODO Print message to log.
        $response['status'] = 'failed';
        $response['message'] = 'Some message';
        exit;
    }

    $response['status'] = 'success';
    $response['message'] = 'Player registered successfully';

    print json_encode($response);
});

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
//    $string = 'Yaniv';
//    print strlen(mb_substr($string, 0, null, "utf-8"));
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
