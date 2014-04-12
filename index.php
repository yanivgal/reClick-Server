<?php

require 'vendor/autoload.php';

use reClick\GCM\GCM;
use reClick\Controllers\Players\Player;
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

    $player = new Player();
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

$app->post('/login/?(hash/:hash/?)', function($hash = 'false') use ($app) {

    $expectedVars = [
        'username',
        'password'
    ];
    $requestVars = initRequestVars($app->request->post(), $expectedVars);

    if ($hash != 'true' && $hash != 'false') {
        (new ResponseMessage(ResponseMessage::FAILED))
            ->addData('message', 'Hash should be true or false')
            ->send();
        exit;
    }

    $player = (new Player())->fromUsername($requestVars['username']);

    // Converts boolean string to real boolean
    $hash = filter_var($hash, FILTER_VALIDATE_BOOLEAN);
    $requestVars['password'] =$hash ?
        $player->hashPassword($requestVars['password']) :
        $requestVars['password'];

    if ($requestVars['password'] != $player->password()) {
        (new ResponseMessage(ResponseMessage::FAILED))
            ->addData('message', 'Username or password are incorrect')
            ->send();
        exit;
    }

    (new ResponseMessage(ResponseMessage::SUCCESS))
        ->addData(
            'message',
            'Hello ' . $player->nickname()
            . '. You\'ve been successfully logged in.'
        )->send();
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
