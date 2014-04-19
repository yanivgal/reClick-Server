<?php

namespace reClick\Routes;

use reClick\Controllers\Players\Player;
use Slim\Slim;
use reClick\Controllers\Games\Games;
use reClick\Framework\ResponseMessage;
use reClick\Controllers\Games\Game;

class GameRouter extends BaseRouter {

    public function getOpenGames() {
        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('games', (new Games())->getOpenGames())
            ->send();
    }

    /**
     * @param int $gameId
     */
    public function getGame($gameId) {
        $game = new Game($gameId);

        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Game does not exist')
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    public function createGame() {
        $app = Slim::getInstance();

        $expectedVars = [
            'username'
        ];
        $requestVars = parent::initRequestVars(
            $app->request->get(),
            $expectedVars
        );

        $player = new Player($requestVars['username']);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Player does not exist')
                ->send();
            exit;
        }

        $game = (new Games())->create();
        $game->addPlayer($player->id());
        $game->playerConfirmed($player->id());

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * @param int $gameId
     * @param string $username
     */
    public function addPlayerToGame($gameId, $username) {
        $game = new Game($gameId);
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Game does not exist')
                ->send();
            exit;
        }

        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Player does not exist')
                ->send();
            exit;
        }

        $game->addPlayer($player->id());

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    /**
     * @param int $gameId
     * @param string $username
     */
    public function playerConfirmed($gameId, $username) {
        $game = new Game($gameId);
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Game does not exist')
                ->send();
            exit;
        }

        $player = new Player($username);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Player does not exist')
                ->send();
            exit;
        }

        if ($player->alreadyConfirmed($gameId)) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Player already confirmed')
                ->send();
            exit;
        }

        $game->playerConfirmed($player->id());

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }

    public function startGame($gameId) {
        $game = new Game($gameId);

        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Game does not exist')
                ->send();
            exit;
        }

        if ($game->started()) {
            (new ResponseMessage(ResponseMessage::FAILED))
                ->addData('message', 'Game already started')
                ->send();
            exit;
        }

        $game->start();

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }
}