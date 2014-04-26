<?php

namespace reClick\Routes;

use Slim\Slim;
use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;
use reClick\Framework\ResponseMessage;

class SessionRouter extends BaseRouter {

    public function __construct() {
        parent::__construct();
    }

    protected function initializeRoutes() {
        $this->app->post(
            '/sign-up/',
            ['reClick\Routes\SessionRouter', 'signUp']
        );

        $this->app->post(
            '/login/?(hash/:hash/?)',
            ['reClick\Routes\SessionRouter', 'login']
        );
    }

    /**
     * POST /sign-up/
     */
    public function signUp() {
        $app = Slim::getInstance();

        $vars = parent::initJsonVars(
            $app->request->getBody(),
            ['username', 'password', 'nickname', 'gcmRegId']
        );

        try {
            $player = (new Players())->create(
                $vars['username'],
                $vars['password'],
                $vars['nickname'],
                $vars['gcmRegId']
            );
        } catch (\PDOException $e) {
            (new ResponseMessage(ResponseMessage::STATUS_ERROR))
                ->message($e->getMessage())
                ->send();
            exit;
        } catch (\Exception $e) {
            (new ResponseMessage(ResponseMessage::STATUS_ERROR))
                ->message($e->getMessage())
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->message('Hello ' . $player->nickname())
            ->addData('username', $player->username())
            ->addData('nickname', $player->nickname())
            ->send();
    }

    /**
     * POST /login/?(hash/:hash/?)
     *
     * @param string $hash
     */
    public function login($hash = 'false') {
        $app = Slim::getInstance();

        $vars = parent::initJsonVars(
            $app->request->getBody(),
            ['username', 'password', 'gcmRegId']
        );

        if ($hash != 'true' && $hash != 'false') {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Hash should be true or false')
                ->send();
            exit;
        }

        $player = new Player($vars['username']);

        // Converts boolean string to real boolean
        $hash = filter_var($hash, FILTER_VALIDATE_BOOLEAN);
        $vars['password'] = $hash ?
            $player->hashPassword($vars['password']) :
            $vars['password'];

        if ($vars['password'] != $player->password()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Invalid Username or Password')
                ->send();
            exit;
        }

        $player->gcmRegId($vars['gcmRegId']);

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->message('Hello ' . $player->nickname())
            ->addData('username', $player->username())
            ->addData('nickname', $player->nickname())
            ->send();
    }
}