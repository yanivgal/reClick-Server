<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;
use reClick\Framework\ResponseMessage;

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
        (new ResponseMessage(ResponseMessage::FAILED))
            ->addData('message', $e->getMessage())
            ->send();
        exit;
    } catch (Exception $e) {
        (new ResponseMessage(ResponseMessage::FAILED))
            ->addData('message', 'Some message')
            ->send();
        exit;
    }

    (new ResponseMessage(ResponseMessage::SUCCESS))
        ->addData('message', 'Player registered successfully')
        ->send();
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
