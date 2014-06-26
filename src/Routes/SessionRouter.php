<?php

namespace reClick\Routes;

use Guzzle\Http\Client;
use Slim\Slim;
use reClick\Controllers\Players\Player;
use reClick\Controllers\Players\Players;
use reClick\Framework\ResponseMessage;

class SessionRouter extends BaseRouter {

    public function __construct() {
        parent::__construct();
    }

    protected function initializeRoutes() {

        $this->app->get(
            '/players/:username/',
            [$this, 'getPlayerInfo']
        );

        $this->app->post(
            '/sign-up/',
            [$this, 'signUp']
        );

        $this->app->post(
            '/login/?(hash/:hash/?)',
            [$this, 'login']
        );

        $this->app->post(
            '/players/:username/location/',
            [$this, 'setPlayerLocation']
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

    /**
     * GET /players/:username/
     *
     * @param string $username
     */
    public function getPlayerInfo($username) {
        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->data($player->toArray())
            ->send();
    }

    /**
     * POST /players/:username/location/
     *
     * @param string $username
     */
    public function setPlayerLocation($username) {
        $app = Slim::getInstance();

        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        $vars = parent::initJsonVars(
            $app->request->getBody(),
            ['latitude', 'longitude']
        );

        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='
            . $vars['latitude'] . ',' . $vars['longitude']
            . '&sensor=false';

        $response = (new Client())
            ->get($url)
            ->send();

        if ($response->getStatusCode() != 200) {
            (new ResponseMessage(ResponseMessage::STATUS_ERROR))
                ->message($response->getMessage())
                ->send();
            exit;
        }

        $location = $response->json()['results'][0]['formatted_address'];

        $player->location($location);

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->message('Location set')
            ->data($player->toArray())
            ->send();
    }
}