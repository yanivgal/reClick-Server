<?php

namespace reClick\Routes;

use Slim\Slim;
use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;
use reClick\Framework\ResponseMessage;

class SessionRouter extends BaseRouter {

    private $app;
    public function __construct() {
        $this->app = Slim::getInstance();
        parent::__construct();
    }

    protected function initializeRoutes() {

    }

    public function signUp() {
        $app = Slim::getInstance();

        $expectedVars = [
            'username',
            'password',
            'nickname',
            'gcmRegId'
        ];
        $requestVars = parent::initRequestVars(
            $app->request->post(),
            $expectedVars
        );

        try {
            $player = (new Players())->create(
                $requestVars['username'],
                $requestVars['password'],
                $requestVars['nickname'],
                $requestVars['gcmRegId']
            );
        } catch (\PDOException $e) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', $e->getMessage())
                ->send();
            exit;
        } catch (\Exception $e) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Some message')
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData(
                'message',
                'Hello ' . $player->nickname()
            )
            ->addData('username', $player->username())
            ->addData('nickname', $player->nickname())
            ->send();
    }

    /**
     * @param string $hash
     */
    public function login($hash = 'false') {
        $app = Slim::getInstance();

        $expectedVars = [
            'username',
            'password',
            'gcmRegId'
        ];
        $requestVars = parent::initRequestVars(
            $app->request->post(),
            $expectedVars
        );

        if ($hash != 'true' && $hash != 'false') {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Hash should be true or false')
                ->send();
            exit;
        }

        $player = new Player($requestVars['username']);

        // Converts boolean string to real boolean
        $hash = filter_var($hash, FILTER_VALIDATE_BOOLEAN);
        $requestVars['password'] = $hash ?
            $player->hashPassword($requestVars['password']) :
            $requestVars['password'];

        if ($requestVars['password'] != $player->password()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Invalid Username or Password')
                ->send();
            exit;
        }

        $player->gcmRegId($requestVars['gcmRegId']);

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData(
                'message',
                'Hello ' . $player->nickname()
            )
            ->addData('username', $player->username())
            ->addData('nickname', $player->nickname())
            ->send();
    }
}