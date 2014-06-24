<?php

namespace reClick\Routes;

use reClick\Controllers\Games\Game;
use reClick\Controllers\Players\Player;
use reClick\Framework\ResponseMessage;
use reClick\GCM\GCM;
use Slim\Slim;

class InGameRouter extends BaseRouter {

    public function __construct() {
        parent::__construct();
    }

    protected function initializeRoutes() {
        $this->app->delete(
            '/games/:gameId/players/:username/',
            [$this, 'deletePlayerFromGame']
        );

        $this->app->post(
            '/games/:gameId/players/:username/sequence/',
            [$this, 'playerMove']
        );
    }

    /**
     * DELETE /games/:gameId/Players/:username
     *
     * @param int $gameId
     * @param string $username
     */
    public function deletePlayerFromGame($gameId, $username) {
        $game = new Game($gameId);
        $player = new Player($username);

        $this->checkExistence($game, $player);

        $previousPlayer = $game->previousPlayer();
        $game->removePlayer($player->id());
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

    /**
     * POST /games/:gameId/players/:username/sequence/
     *
     * @param int $gameId
     * @param string $username
     */
    public function playerMove($gameId, $username) {
        $app = Slim::getInstance();

        $game = new Game($gameId);
        $player = new Player($username);

        $this->checkExistence($game, $player);

        $vars = parent::initJsonVars(
            $app->request->getBody(),
            ['sequence']
        );

        $game->playerMove($vars['sequence']);

        $gcm = new GCM();
        $gcm->message()
            ->addData(
                'message',
                $player->nickname() . ' played his move, now it\' your turn '
            )
            ->addData('gameId', $game->id())
            ->addData('sequence', $game->sequence())
            ->addRegistrationId($game->currentPlayer()->gcmRegId());
        $gcm->sendMessage();

        (new ResponseMessage(ResponseMessage::STATUS_SUCCESS))
            ->message('Player played his move')
            ->send();
    }

    private function checkExistence(Game $game, Player $player) {
        if (!$game->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Game does not exist')
                ->send();
            exit;
        }

        if (!$player->exists()) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist')
                ->send();
            exit;
        }

        if (!$player->existsInGame($game->id())) {
            (new ResponseMessage(ResponseMessage::STATUS_FAIL))
                ->message('Player does not exist in game')
                ->send();
            exit;
        }
    }
} 