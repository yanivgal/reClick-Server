<?php

namespace reClick\Routes;

use reClick\Controllers\Games\Games;
use reClick\Framework\ResponseMessage;
use reClick\Controllers\Games\Game;

class GamesRouter extends BaseRouter {

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
                ->addData('message', 'Game does not exists')
                ->send();
            exit;
        }

        (new ResponseMessage(ResponseMessage::SUCCESS))
            ->addData('game', $game->toArray())
            ->send();
    }
} 