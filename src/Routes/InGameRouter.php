<?php

namespace reClick\Routes;

use reClick\Controllers\Games\Game;
use reClick\Controllers\Players\Player;
use reClick\Framework\ResponseMessage;
use reClick\GCM\GCM;

class InGameRouter extends BaseRouter {

    public function __construct() {
        parent::__construct();
    }

    protected function initializeRoutes() {
        $this->app->delete(
            '/games/:gameId/players/:playerId/',
            [$this, 'deletePlayerFromGame']
        );
    }

    /**
     * DELETE /games/:gameId/Players/:playerId
     *
     * @param $gameId
     * @param $playerId
     */
    public function deletePlayerFromGame($gameId, $playerId) {
        $game = new Game($gameId);
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        $player = new Player($playerId);
        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }
        if (!$player->existsInGame($gameId)) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist in game')
                ->send();
            exit;
        }

        $previousPlayer = $game->previousPlayer();
        $game->removePlayer($playerId);
        $players = $game->players();

        $gcm = new GCM();
        $gcm->message()
            ->addData(
                'message',
                $player->nickname() . ' was unable to repeat '
                . $previousPlayer->nickname()
                . 's sequence and been put out of his misery'
            );

        foreach ($players as $player) {
            $player = new Player($player['id']);
            $gcm->message()->addRegistrationId($player->gcmRegId());
        }

        $gcm->sendMessage();

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->message('Player removed from game')
            ->addData('game', $game->toArray())
            ->send();
    }
} 