<?php

namespace reClick\Routes;

use Slim\Slim;
use reClick\Controllers\Players\Player;
use reClick\Controllers\Games\Games;
use reClick\Framework\ResponseMessage;
use reClick\Controllers\Games\Game;

class GameRouter extends BaseRouter {

    public function __construct() {
        parent::__construct();
    }

    protected  function initializeRoutes() {
        $this->app->get(
            '/games/',
            [$this, 'getOpenGames']
        );

        $this->app->get(
            '/games/:gameId',
            [$this, 'getGame']
        );

        $this->app->post(
            '/games/',
            [$this, 'createGame']
        );

        $this->app->post(
            '/games/:gameId/players/:username',
            [$this, 'addPlayerToGame']
        );

        $this->app->put(
            '/games/:gameId/players/:username',
            [$this, 'playerConfirmed']
        );

        $this->app->post(
            '/games/:gameId/start',
            [$this, 'startGame']
        );
    }

    /**
     * GET /games/
     */
    public function getOpenGames() {
        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('games', (new Games())->getOpenGames())
            ->send();
    }

    /**
     * GET /games/:gameId
     *
     * @param int $gameId
     */
    public function getGame($gameId) {
        $game = new Game($gameId);

        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * POST /games/
     */
    public function createGame() {
        $app = Slim::getInstance();

        $expectedVars = [
            'username'
        ];
        $requestVars = parent::initJsonVars(
            $app->request->getBody(),
            $expectedVars
        );

        $player = new Player($requestVars['username']);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        $game = (new Games())->create();
        $game->addPlayer($player->id());
        $game->playerConfirmed($player->id());

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * POST /games/:gameId/players/:username
     *
     * @param int $gameId
     * @param string $username
     */
    public function addPlayerToGame($gameId, $username) {
        $game = new Game($gameId);
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        $game->addPlayer($player->id());

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * PUT /games/:gameId/players/:username
     *
     * @param int $gameId
     * @param string $username
     */
    public function playerConfirmed($gameId, $username) {
        $game = new Game($gameId);
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        if ($player->alreadyConfirmed($gameId)) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player already confirmed')
                ->send();
            exit;
        }

        $game->playerConfirmed($player->id());

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * PUT /games/:gameId/start
     *
     * @param int $gameId
     */
    public function startGame($gameId) {
        $game = new Game($gameId);

        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        if ($game->started()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game already started')
                ->send();
            exit;
        }

        $game->start();

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }
}